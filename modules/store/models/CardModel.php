<?php

namespace modules\store\models;

use dev\models\UserModel;
use Stripe\Card as StripeCard;

/**
 * Class CardModel
 */
class CardModel
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var string $stripeCardId */
    public $stripeCardId;

    /** @var string $cardNickName */
    public $cardNickName;

    /** @var string $address_city */
    public $address_city;

    /** @var string $address_country */
    public $address_country;

    /** @var string $address_line1 */
    public $address_line1;

    /** @var string $address_line1_check */
    public $address_line1_check;

    /** @var string $address_line2 */
    public $address_line2;

    /** @var string $address_state */
    public $address_state;

    /** @var string $address_zip */
    public $address_zip;

    /** @var string $address_zip_check */
    public $address_zip_check;

    /** @var array $available_payout_methods */
    public $available_payout_methods;

    /** @var string $brand */
    public $brand;

    /** @var string $country */
    public $country;

    /** @var string $currency */
    public $currency;

    /** @var string $cvc_check */
    public $cvc_check;

    /** @var string $dynamic_last4 */
    public $dynamic_last4;

    /** @var int $exp_month */
    public $exp_month;

    /** @var int $exp_year */
    public $exp_year;

    /** @var string $fingerprint */
    public $fingerprint;

    /** @var string $funding */
    public $funding;

    /** @var string $last4 */
    public $last4;

    /** @var string $name */
    public $name;

    /**
     * CardModel constructor
     * @param StripeCard|null $stripeCard
     * @param UserModel $userModel
     */
    public function __construct(
        StripeCard $stripeCard = null,
        UserModel $userModel = null
    ) {
        if ($stripeCard) {
            $this->populateFromStripeCardObject($stripeCard);
        }

        if ($userModel) {
            $this->userId = $userModel->userId;
        }
    }

    /**
     * Populates the model from the stripe object
     * @param StripeCard $stripeCard
     */
    public function populateFromStripeCardObject(StripeCard $stripeCard)
    {
        $this->stripeCardId = $stripeCard->id;
        $this->cardNickName = $stripeCard->metadata->cardNickName;

        foreach ($stripeCard->keys() as $key) {
            if ($key === 'id' ||
                $key === 'userId' ||
                $key === 'stripeCardId' ||
                $key === 'cardNickName' ||
                ! property_exists($this, $key)
            ) {
                continue;
            }

            $this->{$key} = $stripeCard->{$key};
        }
    }

    /**
     * Gets database save data
     * @param bool $includeId
     * @return array
     */
    public function getSaveData(bool $includeId = true): array
    {
        $saveData = [
            'id' => $this->id,
            'userId' => $this->userId,
            'stripeCardId' => $this->stripeCardId,
            'cardNickName' => $this->cardNickName,
        ];

        if (! $includeId) {
            unset($saveData['id']);
        }

        return $saveData;
    }

    /**
     * Gets a full textual representation of the expiration month
     * @return string
     */
    public function getExpMonthLong(): string
    {
        $date = \DateTime::createFromFormat(
            'n-j-Y',
            $this->exp_month . '-15-' . $this->exp_year
        );

        return $date->format('F');
    }
}
