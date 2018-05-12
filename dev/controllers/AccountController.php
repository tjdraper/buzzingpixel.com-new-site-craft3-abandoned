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

        // TODO: Display account page
        var_dump('TODO: Display account page');
        die;
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
