<?php

namespace modules\store;

use Craft;
use Stripe\Stripe;
use yii\base\Module;
use Ramsey\Uuid\Uuid;
use Stripe\Charge as StripeCharge;
use modules\store\models\CartModel;
use modules\store\services\CartService;
use modules\store\services\OrderService;
use modules\store\factories\QueryFactory;
use modules\store\services\CookieService;
use modules\store\factories\ConfigFactory;
use modules\store\models\StoreConfigModel;
use modules\store\factories\CookieFactory;
use modules\store\services\ChargeCardService;
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
     */
    public static function chargeCardService(): ChargeCardService
    {
        return new ChargeCardService(new StripeCharge());
    }

    /**
     * Gets the order service
     * @return OrderService
     */
    public static function orderService(): OrderService
    {
        return new OrderService(Craft::$app->getDb(), Uuid::getFactory());
    }
}
