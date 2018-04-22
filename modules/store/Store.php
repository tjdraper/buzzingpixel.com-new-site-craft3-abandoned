<?php

namespace modules\store;

use Craft;
use yii\base\Module;

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
        parent::init();
    }
}
