<?php

namespace modules\store\models;

use modules\store\Store;

/**
 * Class OrderItemModel
 */
class OrderItemModel
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var int $orderId */
    public $orderId;

    /** @var string $key */
    public $key;

    /** @var string $title */
    public $title;

    /** @var string $version */
    public $version;

    /** @var int $price */
    public $price;

    /** @var int $originalPrice */
    public $originalPrice;

    /** @var bool $isUpgrade */
    public $isUpgrade;

    /** @var bool $hasBeenUpgraded */
    public $hasBeenUpgraded;

    /** @var bool $requiresSubscription */
    public $requiresSubscription;

    /** @var bool $isSubscribed */
    public $isSubscribed;

    /** @var string $licenseKey */
    public $licenseKey;

    /** @var string $notes */
    public $notes;

    /** @var array $authorizedDomains */
    public $authorizedDomains;

    /** @var bool $disabled */
    public $disabled;

    /**
     * Gets the related store product model
     * @return StoreProductModel
     */
    public function getStoreProductModel(): StoreProductModel
    {
        return Store::settings()->products[$this->key];
    }

    /**
     * Adds an authorized domain
     * @param string $domain
     */
    public function addAuthorizedDomain(string $domain)
    {
        $this->authorizedDomains[uniqid('', false)] = $domain;
    }

    /**
     * Gets database save data
     * @param bool $includeId
     * @return array
     */
    public function getSaveData(bool $includeId = true): array
    {
        $authorizedDomains = $this->authorizedDomains;

        if (! \is_array($authorizedDomains)) {
            $authorizedDomains = [];
        }

        $saveData = [
            'id' => $this->id,
            'userId' => $this->userId,
            'orderId' => $this->orderId,
            'key' => $this->key,
            'title' => $this->title,
            'version' => $this->version,
            'price' => $this->price,
            'originalPrice' => $this->originalPrice,
            'isUpgrade' => $this->isUpgrade ? '1' : '0',
            'hasBeenUpgraded' => $this->hasBeenUpgraded ? '1' : '0',
            'requiresSubscription' => $this->requiresSubscription ? '1' : '0',
            'isSubscribed' => $this->isSubscribed ? '1' : '0',
            'licenseKey' => $this->licenseKey,
            'notes' => $this->notes,
            'authorizedDomains' => json_encode($authorizedDomains),
            'disabled' => $this->disabled ? '1' : '0',
        ];

        if (! $includeId) {
            unset($saveData['id']);
        }

        return $saveData;
    }
}
