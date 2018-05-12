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
     * Displays the forgot password page
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
