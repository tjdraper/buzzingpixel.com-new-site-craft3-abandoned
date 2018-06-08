<?php

namespace dev\models;

use felicity\datamodel\Model;
use felicity\datamodel\services\datahandlers\EmailHandler;
use felicity\datamodel\services\datahandlers\IntHandler;
use felicity\datamodel\services\datahandlers\StringHandler;
use felicity\datamodel\services\datahandlers\DateTimeHandler;

/**
 * Class UserModel
 */
class UserModel extends Model
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var string $emailAddress */
    public $emailAddress;

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

    /** @var \DateTime $dateCreated */
    public $dateCreated;

    /** @var \DateTime $dateUpdated */
    public $dateUpdated;

    /** @var string $uid */
    public $uid;

    /**
     * @inheritdoc
     */
    protected function defineHandlers(): array
    {
        return [
            'id' => IntHandler::class,
            'userId' => IntHandler::class,
            'emailAddress' => EmailHandler::class,
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
            'dateCreated' => DateTimeHandler::class,
            'dateUpdated' => DateTimeHandler::class,
            'uid' => StringHandler::class,
        ];
    }

    /**
     * Gets database save data
     * @param bool $includeId
     * @return array
     * @throws \ReflectionException
     */
    public function getSaveData($includeId = true): array
    {
        $saveData = [
            'id' => $this->getProperty('id'),
            'userId' => $this->getProperty('userId'),
            'stripeCustomerId' => $this->getProperty('stripeCustomerId'),
            'displayName' => $this->getProperty('displayName'),
            'billingPhoneNumber' => $this->getProperty('billingPhoneNumber'),
            'billingCountry' => $this->getProperty('billingCountry'),
            'billingName' => $this->getProperty('billingName'),
            'billingCompany' => $this->getProperty('billingCompany'),
            'billingAddress' => $this->getProperty('billingAddress'),
            'billingAddressContinued' => $this->getProperty('billingAddressContinued'),
            'billingCity' => $this->getProperty('billingCity'),
            'billingStateProvince' => $this->getProperty('billingStateProvince'),
            'billingPostalCode' => $this->getProperty('billingPostalCode'),
        ];

        if (! $includeId) {
            unset($saveData['id']);
        }

        return $saveData;
    }
}
