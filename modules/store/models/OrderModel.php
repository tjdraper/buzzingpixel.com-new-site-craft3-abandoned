<?php

namespace modules\store\models;

/**
 * Class OrderModel
 */
class OrderModel
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var string $transactionId */
    public $transactionId;

    /** @var int $transactionAmount */
    public $transactionAmount;

    /** @var string $balanceTransactionId */
    public $balanceTransactionId;

    /** @var bool $transactionCaptured */
    public $transactionCaptured;

    /** @var \DateTime $transactionCreated */
    public $transactionCreated;

    /** @var string $transactionCurrency */
    public $transactionCurrency;

    /** @var string $transactionDescription */
    public $transactionDescription;

    /** @var float $subTotal */
    public $subTotal;

    /** @var float $tax */
    public $tax;

    /** @var float $total */
    public $total;

    /** @var string $name */
    public $name;

    /** @var string $company */
    public $company;

    /** @var string $phoneNumber */
    public $phoneNumber;

    /** @var string $country */
    public $country;

    /** @var string $address */
    public $address;

    /** @var string $addressContinued */
    public $addressContinued;

    /** @var string $city */
    public $city;

    /** @var string $stateProvince */
    public $stateProvince;

    /** @var string $postalCode */
    public $postalCode;
}
