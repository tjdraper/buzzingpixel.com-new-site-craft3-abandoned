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
            return $this->renderTemplate('_core/PageStandard.twig', [
                'contentModel' => null,
                'content' => null,
                'contentMeta' => null,
                'metaTitle' => 'Empty Cart',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Empty Cart',
                    ],
                ],
                'contentBlocks' => [[
                    'meta' => [
                        'blockType' => 'standard',
                        'heading' => 'Empty Cart',
                    ],
                    'html' => '<p>You don\'t have anything in your cart yet. But that\'s easy to fix. Up above in the menu, select one of the products from the "software" menu!</p>',
                ]],
            ]);
        }

        return $this->renderTemplate(
            '_core/Cart.twig',
            [],
            false
        );
    }
}
