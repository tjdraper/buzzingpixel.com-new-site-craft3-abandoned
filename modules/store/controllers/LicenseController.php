<?php

namespace modules\store\controllers;

use Craft;
use yii\web\Response;
use modules\store\Store;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use modules\store\models\OrderItemModel;
use craft\web\Request as RequestService;
use modules\store\factories\OrderItemsQueryFactory;

/**
 * Class LicenseController
 */
class LicenseController extends Controller
{
    /** @var OrderItemModel $license */
    private $license;

    /** @var RequestService $requestService */
    private $requestService;

    /**
     * Initialize controller request
     * @throws BadRequestHttpException
     */
    public function init()
    {
        parent::init();

        $this->requirePostRequest();

        if (Craft::$app->getUser()->isGuest) {
            throw new BadRequestHttpException(
                'You must be logged in to perform this action.'
            );
        }

        $this->requestService = Craft::$app->getRequest();

        $this->license = OrderItemsQueryFactory::getFactory()
            ->where('userId', Craft::$app->getUser()->getId())
            ->where('disabled', 0)
            ->where('id', (int) $this->requestService->post('licenseId'))
            ->one();

        if (! $this->license) {
            throw new BadRequestHttpException(
                'The specified license was not found.'
            );
        }
    }

    /**
     * Adds a domain to a license
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionAddDomain(): Response
    {
        $this->license->addAuthorizedDomain(
            $this->requestService->post('domain')
        );

        Store::orderService()->saveOrderItem($this->license);

        return $this->redirect(
            $this->requestService->post('redirect', '/account')
        );
    }

    /**
     * Adds a domain to a license
     * @return Response
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionRemoveDomain(): Response
    {
        $this->license->removeAuthorizedDomain(
            $this->requestService->post('domainId')
        );

        Store::orderService()->saveOrderItem($this->license);

        return $this->redirect(
            $this->requestService->post('redirect', '/account')
        );
    }

    /**
     * Edits the notes on a license
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionUpdateNotes()
    {
        $this->license->notes = $this->requestService->post('notes');

        Store::orderService()->saveOrderItem($this->license);

        return $this->redirect(
            $this->requestService->post('redirect', '/account')
        );
    }
}
