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
     */
    public function actionForgotPassword()
    {
        return $this->renderTemplate(
            '_core/ResetPassword.twig',
            [
                'metaTitle' => 'Reset Your Password',
                'metaDescription' => null,
                'header' => [
                    'meta' => [
                        'heading' => 'Reset Your Password',
                    ],
                ],
            ],
            false
        );
    }
}
