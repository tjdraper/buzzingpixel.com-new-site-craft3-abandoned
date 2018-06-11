<?php

namespace dev\controllers;

use Craft;
use dev\Module;
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
            return $this->renderTemplate(
                '_core/PageStandard.twig',
                [
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
                ],
                false
            );
        }

        return $this->renderTemplate(
            '_core/Cart.twig',
            array_merge(
                [
                    'header' => [
                        'meta' => [
                            'heading' => 'Checkout',
                        ],
                    ],
                    'cartModel' => Store::cartService()->getCartModel(),
                    'isGuest' => Craft::$app->getUser()->isGuest,
                    'checkoutInputErrors' => [],
                    'checkoutErrorMessage' => '',
                    'userCards' => Store::stripeUserService()->getUserCards(
                        Module::userService()->getUserModel()
                    ),
                ],
                Craft::$app->getUrlManager()->getRouteParams()
            ),
            false
        );
    }
}
