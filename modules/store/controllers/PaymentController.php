<?php

namespace modules\store\controllers;

use Craft;
use dev\Module;
use yii\web\Response;
use modules\store\Store;
use craft\web\Controller;
use yii\db\Exception as DbException;
use yii\web\BadRequestHttpException;

/**
 * Class PaymentController
 */
class PaymentController extends Controller
{
    /**
     * Deletes a payment method
     * @return Response
     * @throws BadRequestHttpException
     * @throws \ReflectionException
     * @throws DbException
     * @throws \LogicException
     */
    public function actionDelete(): Response
    {
        $this->requirePostRequest();

        if (Craft::$app->getUser()->isGuest) {
            throw new BadRequestHttpException(
                'You must be logged in to perform this action.'
            );
        }

        $stripeUserService = Store::stripeUserService();
        $requestService = Craft::$app->getRequest();

        $card = $stripeUserService->getCardByLocalId(
            (int) $requestService->post('localCardId'),
            Module::userService()->getUserModel()
        );

        if (! $card) {
            throw new BadRequestHttpException(
                'The specified card was not found.'
            );
        }

        $stripeUserService->deleteCard($card);

        return $this->redirect($requestService->post('redirect', '/account'));
    }
}
