<?php

namespace dev\controllers;

use Craft;
use yii\web\Response;
use craft\elements\User;
use yii\web\HttpException;
use craft\helpers\DateTimeHelper;

/**
 * Class AccountController
 */
class AccountController extends BaseController
{
    private static $secionNav = [
        'licenses' => [
            'content' => 'Licenses',
            'url' => '/account',
            'isActive' => false,
        ],
        'payment' => [
            'content' => 'Payment Methods',
            'url' => '/account/payment',
            'isActive' => false,
        ],
        'subscriptions' => [
            'content' => 'Subscriptions',
            'url' => '/account/subscriptions',
            'isActive' => false,
        ],
        'profile' => [
            'content' => 'Profile',
            'url' => '/account/profile',
            'isActive' => false,
        ],
    ];

    /**
     * Displays user account page
     */
    public function actionIndex()
    {
        // If the user is a guest, we need for them to log in
        if (Craft::$app->getUser()->getIsGuest()) {
            return $this->renderTemplate(
                '_core/StandAloneLoginForm.twig',
                array_merge(Craft::$app->getUrlManager()->getRouteParams(), [
                    'metaTitle' => 'Log in to your account',
                    'metaDescription' => null,
                ]),
                false
            );
        }

        $sectionNav = self::$secionNav;

        $sectionNav['licenses']['isActive'] = true;

        return $this->renderTemplate(
            '_core/PageStandard.twig',
            [
                'contentModel' => null,
                'content' => null,
                'contentMeta' => null,
                'metaTitle' => 'Your Licenses',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Your Licenses',
                    ],
                ],
                'contentBlocks' => [
                    [
                        'meta' => [
                            'blockType' => 'navBar',
                            'navItems' => $sectionNav
                        ],
                    ],
                    [
                        'meta' => [
                            'blockType' => 'standard',
                        ],
                        'html' => '<p>TODO: Build out licenses page</p>'
                    ],
                ],
            ],
            false
        );
    }

    /**
     * Displays forgot password page
     * @throws HttpException
     */
    public function actionForgotPassword()
    {
        if (! Craft::$app->getUser()->getIsGuest()) {
            throw new HttpException(400, 'User is already logged in');
        }

        return $this->renderTemplate(
            '_core/ResetPassword.twig',
            array_merge(Craft::$app->getUrlManager()->getRouteParams(), [
                'metaTitle' => 'Reset Your Password',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Reset Your Password',
                    ],
                ],
            ]),
            false
        );
    }
}
