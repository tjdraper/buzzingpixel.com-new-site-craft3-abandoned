<?php

namespace modules\store\services;

use Stripe\ApiResource;
use dev\models\UserModel;
use Stripe\Charge as StripeCharge;
use modules\store\models\CartModel;
use modules\store\models\CardModel;

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
     * @param CardModel $cardModel
     * @param CartModel $cartModel
     * @param UserModel $userModel
     * @return ApiResource
     * @throws \LogicException
     */
    public function charge(
        CardModel $cardModel,
        CartModel $cartModel,
        UserModel $userModel
    ): ApiResource {
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
            'source' => $cardModel->stripeCardId,
        ]);
    }
}
