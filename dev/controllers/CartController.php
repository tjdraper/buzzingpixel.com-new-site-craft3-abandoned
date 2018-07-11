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

        $userCards = [];

        $userModel = Module::userService()->getUserModel();

        if (! Craft::$app->getUser()->isGuest) {
            $userCards = Store::stripeUserService()->getUserCards($userModel);
        }

        return $this->renderTemplate(
            '_core/Cart.twig',
            array_merge(
                [
                    'metaTitle' => 'Your Cart',
                    'header' => [
                        'meta' => [
                            'heading' => 'Checkout',
                        ],
                    ],
                    'cartModel' => Store::cartService()->getCartModel(),
                    'isGuest' => Craft::$app->getUser()->isGuest,
                    'checkoutInputErrors' => [],
                    'checkoutErrorMessage' => '',
                    'userCards' => $userCards,
                    'userModel' => $userModel,
                ],
                Craft::$app->getUrlManager()->getRouteParams()
            ),
            false
        );
    }

    /**
     * Displays the order success page
     * @return Response
     * @throws \HttpException
     */
    public function actionOrderSuccess(): Response
    {
        if (Craft::$app->getUser()->isGuest) {
            throw new \HttpException(404);
        }

        $orderService = Store::orderService();

        $orderModel = $orderService->getMostRecentUserOrder(
            Craft::$app->getUser()->getId()
        );

        return $this->renderTemplate(
            '_core/PageStandard.twig',
            [
                'contentModel' => null,
                'content' => null,
                'contentMeta' => null,
                'metaTitle' => 'Your Order',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Your Order',
                    ],
                ],
                'contentBlocks' => [[
                    'meta' => [
                        'blockType' => 'standard',
                        'ctaGroup' => [[
                            'style' => 'orangeOutline',
                            'content' => 'View your account &raquo;',
                            'link' => '/account',
                        ]],
                    ],
                    'html' => '<p>Your order has been placed successfully! We&rsquo;ve sent the order details to your email address. The order number of your order is <strong>' . $orderModel->id . '</strong>. To see more details about your order, access downloads, print the invoice for your records and more, visit your account page.</p>',
                ]],
            ],
            false
        );
    }
}
