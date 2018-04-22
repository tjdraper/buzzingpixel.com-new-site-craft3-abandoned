<?php

namespace modules\store;

use Craft;
use yii\base\Module;
use craft\console\Application as ConsoleApplication;

/**
 * Class Store
 */
class Store extends Module
{
    /**
     * Initializes the module
     * @throws \Exception
     */
    public function init()
    {
        Craft::setAlias('@store', __DIR__);

        // Add in our console commands
        if (Craft::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'store\commands';
        }

        parent::init();
    }
}
