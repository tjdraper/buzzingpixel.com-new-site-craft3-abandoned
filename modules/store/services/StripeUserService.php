<?php

namespace modules\store\services;

use dev\models\UserModel;
use dev\services\UserService;
use yii\db\Exception as DbException;
use Stripe\Customer as StripeCustomer;
use modules\store\factories\QueryFactory;

/**
 * Class StripeUserService
 */
class StripeUserService
{
    /** @var StripeCustomer $stripeCustomer */
    private $stripeCustomer;

    /** @var UserService $userService */
    private $userService;

    /** @var QueryFactory $queryFactory */
    public $queryFactory;

    /**
     * StripeUserService constructor
     * @param StripeCustomer $stripeCustomer
     * @param UserService $userService
     * @param QueryFactory $queryFactory
     */
    public function __construct(
        StripeCustomer $stripeCustomer,
        UserService $userService,
        QueryFactory $queryFactory
    ) {
        $this->stripeCustomer = $stripeCustomer;
        $this->userService = $userService;
        $this->queryFactory = $queryFactory;
    }

    /**
     * Creates a Stripe user
     * @param UserModel $userModel
     * @throws \LogicException
     * @throws \ReflectionException
     * @throws DbException
     * @throws \Exception
     */
    public function touchStripeUser(UserModel $userModel)
    {
        $metaData = [
            'displayName' => $userModel->displayName,
            'billingPhoneNumber' => $userModel->billingPhoneNumber,
            'billingCountry' => $userModel->billingCountry,
            'billingName' => $userModel->billingName,
            'billingCompany' => $userModel->billingCompany,
            'billingAddress' => $userModel->billingAddress,
            'billingAddressContinued' => $userModel->billingAddressContinued,
            'billingCity' => $userModel->billingCity,
            'billingStateProvince' => $userModel->billingStateProvince,
            'billingPostalCode' => $userModel->billingPostalCode,
        ];

        if (! $userModel->stripeCustomerId) {
            $createResponse = $this->stripeCustomer::create([
                'description' => 'BuzzingPixel.com customer',
                'email' => $userModel->emailAddress,
                'metadata' => $metaData,
            ]);

            if ($createResponse || ! isset($createResponse->id)) {
                throw new \LogicException('Unable to create customer on Stripe');
            }

            $userModel->stripeCustomerId = $createResponse->id;

            $this->userService->saveUser($userModel);
            return;
        }

        $customer = $this->stripeCustomer::retrieve($userModel->stripeCustomerId);
        $customer->description = 'BuzzingPixel.com customer';
        $customer->email = $userModel->emailAddress;
        $customer->metadata = $metaData;
        $customer->save();
    }

    /**
     * Gets user cards
     * @param UserModel $userModel
     * @throws \ReflectionException
     * @return array
     */
    public function getUserCards(UserModel $userModel): array
    {
        $query = $this->queryFactory->getQuery()->from('{{%storeCards}}')
            ->where("`userId` = '{$userModel->getProperty('userId')}'")
            ->all();

        if (! $query) {
            return [];
        }

        // TODO: build card models array
        var_dump($query);
        die;
    }
}