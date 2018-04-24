<?php

namespace dev\controllers;

use yii\web\Response;
use modules\store\Store;

/**
 * Class CartController
 */
class CartController extends BaseController
{
    /**
     * Displays the Cart page
     * @return Response
     * @throws \Exception
     */
    public function actionIndex(): Response
    {
        if (! Store::cartService()->count()) {
            // TODO: Display standard block that says cart is empty
            var_dump('TODO: Display standard block that says cart is empty');
            die;
        }

        return $this->renderTemplate(
            '_core/Cart.twig',
            [],
            false
        );
    }
}
