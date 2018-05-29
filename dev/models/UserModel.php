<?php

namespace dev\models;

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\IntHandler;
use felicity\datamodel\services\datahandlers\StringHandler;

/**
 * Class UserModel
 */
class UserModel extends Model
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var string $stripeCustomerId */
    public $stripeCustomerId;

    /** @var string $displayName */
    public $displayName;

    /** @var string $billingPhoneNumber */
    public $billingPhoneNumber;

    /** @var string $billingCountry */
    public $billingCountry;

    /** @var string $billingName */
    public $billingName;

    /** @var string $billingCompany */
    public $billingCompany;

    /** @var string $billingAddress */
    public $billingAddress;

    /** @var string $billingAddressContinued */
    public $billingAddressContinued;

    /** @var string $billingCity */
    public $billingCity;

    /** @var string $billingStateProvince */
    public $billingStateProvince;

    /** @var string $billingPostalCode */
    public $billingPostalCode;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'id' => IntHandler::class,
            'userId' => IntHandler::class,
            'stripeCustomerId' => StringHandler::class,
            'displayName' => StringHandler::class,
            'billingPhoneNumber' => StringHandler::class,
            'billingCountry' => StringHandler::class,
            'billingName' => StringHandler::class,
            'billingCompany' => StringHandler::class,
            'billingAddress' => StringHandler::class,
            'billingAddressContinued' => StringHandler::class,
            'billingCity' => StringHandler::class,
            'billingStateProvince' => StringHandler::class,
            'billingPostalCode' => StringHandler::class,
        ];
    }
}
