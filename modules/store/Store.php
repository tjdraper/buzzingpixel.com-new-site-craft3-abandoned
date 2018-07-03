<?php

namespace modules\store;

use Craft;
use Stripe\Stripe;
use yii\base\Module;
use Ramsey\Uuid\Uuid;
use dev\Module as DevModule;
use Stripe\Charge as StripeCharge;
use modules\store\models\CartModel;
use yii\db\Exception as DbException;
use Stripe\Customer as StripeCustomer;
use modules\store\services\CartService;
use modules\store\services\OrderService;
use modules\store\factories\QueryFactory;
use modules\store\services\CookieService;
use modules\store\factories\ConfigFactory;
use modules\store\models\StoreConfigModel;
use modules\store\factories\CookieFactory;
use modules\store\services\ChargeCardService;
use modules\store\services\StripeUserService;
use modules\store\services\SubscriptionService;
use craft\console\Application as ConsoleApplication;

/**
 * Class Store
 */
class Store extends Module
{
    /** @var Store $plugin */
    public static $plugin;

    /** @var array $storage */
    private $storage = array();

    /**
     * Initializes the module
     * @throws \Exception
     */
    public function init()
    {
        self::$plugin = $this;

        Craft::setAlias('@store', __DIR__);

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'store\commands';
        }

        // Set the stripe key
        Stripe::setApiKey(self::settings()->stripeSecretKey);

        // Set the stripe API version
        Stripe::setApiVersion('2018-02-28');

        parent::init();
    }



    /**************************************************************************/
    /* Dependency injection */
    /**************************************************************************/

    /**
     * Gets the settings model
     * @return StoreConfigModel
     */
    public static function settings(): StoreConfigModel
    {
        if (! isset(self::$plugin->storage['SettingsModel'])) {
            self::$plugin->storage['SettingsModel'] = ConfigFactory::createConfigModel(
                Craft::$app->getConfig()->getConfigFromFile('store')
            );
        }

        return self::$plugin->storage['SettingsModel'];
    }

    /**
     * Gets the Cart Service
     * @return CartService
     * @throws \Exception
     */
    public static function cartService(): CartService
    {
        if (! isset(self::$plugin->storage['CartService'])) {
            self::$plugin->storage['CartService'] = new CartService(
                self::settings(),
                new CartModel(),
                Craft::$app->getUser()->getId() ?? 0,
                new QueryFactory(),
                Craft::$app->getDb(),
                self::cookieService(),
                Uuid::getFactory()
            );
        }

        return self::$plugin->storage['CartService'];
    }

    /**
     * Gets the Cookie Service
     * @return CookieService
     */
    public static function cookieService(): CookieService
    {
        if (! isset(self::$plugin->storage['CookieService'])) {
            $cookies = \is_array($_COOKIE) ? $_COOKIE : [];

            self::$plugin->storage['CookieService'] = new CookieService(
                $cookies,
                new CookieFactory()
            );
        }

        return self::$plugin->storage['CookieService'];
    }

    /**
     * Gets the Charge Card Service
     * @return ChargeCardService
     * @throws \LogicException
     */
    public static function chargeCardService(): ChargeCardService
    {
        return new ChargeCardService(new StripeCharge());
    }

    /**
     * Gets the Order Service
     * @return OrderService
     */
    public static function orderService(): OrderService
    {
        return new OrderService(
            Craft::$app->getDb(),
            new QueryFactory(),
            Uuid::getFactory()
        );
    }

    /**
     * Gets the Subscription Service
     * @return SubscriptionService
     */
    public static function subscriptionService(): SubscriptionService
    {
        return new SubscriptionService();
    }

    /**
     * Gets the Stripe User Service
     * @return StripeUserService
     * @throws DbException
     * @throws \ReflectionException
     */
    public static function stripeUserService(): StripeUserService
    {
        return new StripeUserService(
            new StripeCustomer(),
            DevModule::userService(),
            new QueryFactory()
        );
    }
}
