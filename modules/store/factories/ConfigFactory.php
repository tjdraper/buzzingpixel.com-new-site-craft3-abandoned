<?php

namespace modules\store\factories;

use modules\store\models\StoreConfigModel;
use modules\store\models\StoreProductModel;

/**
 * Class SettingsFactory
 */
class ConfigFactory
{
    /**
     * Creates the store settings model
     * @param array $settingsArray
     * @return StoreConfigModel
     */
    public static function createConfigModel(array $settingsArray): StoreConfigModel
    {
        $products = $settingsArray['products'] ?? [];
        unset($settingsArray['products']);

        $configModel = new StoreConfigModel();

        foreach ($settingsArray as $key => $val) {
            $configModel->{$key} = $val;
        }

        foreach ($products as $key => $val) {
            $model = new StoreProductModel();

            foreach ($val as $k => $v) {
                $model->{$k} = $v;
            }

            $configModel->products[$key] = $model;
        }

        return $configModel;
    }
}
