<?php

namespace modules\store\controllers;

use craft\web\Controller;

/**
 * Class CartContentController
 */
class CartContentController extends Controller
{
    protected $allowAnonymous = true;

    /**
     * Adds an item to the cart
     * @param string $productKey
     */
    public function actionAdd(string $productKey)
    {
        var_dump('here', $productKey);
        die;
    }
}
