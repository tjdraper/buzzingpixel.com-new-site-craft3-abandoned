<?php

namespace modules\store\services;

use Stripe\ApiResource;
use dev\models\UserModel;
use Stripe\Charge as StripeCharge;
use modules\store\models\CartModel;
use modules\store\models\PaymentModel;

/**
 * Class ChargeCardService
 */
class ChargeCardService
{
    /** @var StripeCharge $stripeCharge */
    private $stripeCharge;

    /**
     * ChargeCardService constructor
     * @param StripeCharge $stripeCharge
     * @throws \LogicException
     */
    public function __construct(StripeCharge $stripeCharge)
    {
        $this->stripeCharge = $stripeCharge;
    }

    /**
     * Charges the card
     * @param PaymentModel $paymentModel
     * @param CartModel $cartModel
     * @param UserModel $userModel
     * @return ApiResource
     * @throws \LogicException
     */
    public function charge(
        PaymentModel $paymentModel,
        CartModel $cartModel,
        UserModel $userModel
    ): ApiResource {
        $validationErrors = array_merge(
            $paymentModel->validateForCheckout(),
            $cartModel->validateForCheckout()
        );

        if (\count($validationErrors) > 0) {
            throw new \LogicException(
                'Charge requires valid payment and cart models. ' .
                'Please validate these models before running this method'
            );
        }

        $description = 'BuzzingPixel.com Order:';

        $first = true;

        $productModels = $cartModel->getProductModels();

        foreach ($productModels as $productModel) {
            if (! $first) {
                $description .= ',';
            }

            $description .= " {$productModel->title} ({$productModel->qty})";

            $first = false;
        }

        return $this->stripeCharge::create([
            'amount' => $cartModel->getTotal() * 100,
            'currency' => 'usd',
            'description' => $description,
            'receipt_email' => $userModel->emailAddress,
            'statement_descriptor' => 'BuzzingPixel, LLC',
            'customer' => $userModel->stripeCustomerId,
            'source' => [
                'exp_month' => $paymentModel->expireMonth,
                'exp_year' => $paymentModel->expireYear,
                'number' => $paymentModel->cardNumber,
                'object' => 'card',
                'cvc' => $paymentModel-> cvc,
                'address_city' => $cartModel->city,
                'address_country' => $cartModel->country,
                'address_line1' => $cartModel->address,
                'address_line2' => $cartModel->addressContinued,
                'name' => $cartModel->name,
                'address_state' => $cartModel->stateProvince,
                'address_zip' => $cartModel->postalCode,
            ],
        ]);
    }
}
