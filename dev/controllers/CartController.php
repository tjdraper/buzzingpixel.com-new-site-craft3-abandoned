<?php

namespace dev\controllers;

use yii\web\Response;

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
        return $this->renderTemplate(
            '_core/Cart.twig',
            [],
            false
        );
    }
}
