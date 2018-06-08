<?php

namespace modules\store\services;

use dev\models\UserModel;
use dev\services\UserService;
use yii\db\Exception as DbException;
use Stripe\Customer as StripeCustomer;

/**
 * Class StripeUserService
 */
class StripeUserService
{
    /** @var StripeCustomer $stripeCustomer */
    private $stripeCustomer;

    /** @var UserService $userService */
    private $userService;

    /**
     * StripeUserService constructor
     * @param StripeCustomer $stripeCustomer
     * @param UserService $userService
     */
    public function __construct(
        StripeCustomer $stripeCustomer,
        UserService $userService
    ) {
        $this->stripeCustomer = $stripeCustomer;
        $this->userService = $userService;
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
}
