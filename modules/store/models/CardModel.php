<?php

namespace modules\store\models;

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
}
