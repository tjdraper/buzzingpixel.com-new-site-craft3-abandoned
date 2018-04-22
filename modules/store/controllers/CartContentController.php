<?php

namespace modules\store\controllers;

use Craft;
use yii\web\Response;
use modules\store\Store;
use craft\web\Controller;
use yii\web\HttpException;
use craft\helpers\UrlHelper;

/**
 * Class CartContentController
 */
class CartContentController extends Controller
{
    protected $allowAnonymous = true;

    /**
     * Adds an item to the cart
     * @param string $productKey
     * @return Response
     * @throws \Exception
     */
    public function actionAdd(string $productKey): Response
    {
        if (! Store::cartService()->add($productKey)) {
            throw new HttpException(500, 'Product not found');
        }

        return $this->redirect(
            Craft::$app->getRequest()->get('redirect', '/cart')
        );
    }
}
