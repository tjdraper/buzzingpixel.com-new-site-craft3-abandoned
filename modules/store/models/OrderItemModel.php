<?php

namespace modules\store\models;

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
}
