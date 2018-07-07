<?php

namespace modules\store\controllers;

use Craft;
use craft\web\Controller;
use modules\store\Store;
use yii\web\BadRequestHttpException;
use modules\store\factories\OrderItemsQueryFactory;

/**
 * Class LicenseController
 */
class LicenseController extends Controller
{
    /**
     * Initialize controller request
     * @throws BadRequestHttpException
     */
    public function init()
    {
        parent::init();

        if (Craft::$app->getUser()->isGuest) {
            throw new BadRequestHttpException(
                'You must be logged in to perform this action.'
            );
        }
    }

    /**
     * Adds a domain to a license
     * @throws \Exception
     * @throws \Throwable
     * @throws BadRequestHttpException
     */
    public function actionAddDomain()
    {
        $this->requirePostRequest();

        $requestService = Craft::$app->getRequest();

        $license = OrderItemsQueryFactory::getFactory()
            ->where('userId', Craft::$app->getUser()->getId())
            ->where('disabled', 0)
            ->where('id', (int) $requestService->post('licenseId'))
            ->one();

        if (! $license) {
            throw new BadRequestHttpException(
                'The license specified was not found.'
            );
        }

        $license->addAuthorizedDomain($requestService->post('domain'));

        Store::orderService()->saveOrderItem($license);

        return $this->redirect($requestService->post('redirect', '/account'));
    }
}
