<?php

namespace modules\store;

use Craft;
use yii\base\Module;
use modules\store\services\CartService;
use modules\store\factories\QueryFactory;
use modules\store\factories\ConfigFactory;
use modules\store\models\StoreConfigModel;
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
        // Make sure session is started
        Craft::$app->getSession()->open();

        return new CartService(
            self::settings(),
            Craft::$app->getSession()->getId(),
            Craft::$app->getUser()->getId() ?? 0,
            new QueryFactory(),
            Craft::$app->getDb()
        );
    }
}
