<?php

namespace modules\store\models;

/**
 * Class StoreProductModel
 */
class StoreProductModel
{
    /** @var string $key */
    public $key;

    /** @var string $title */
    public $title;

    /** @var string $url */
    public $url;

    /** @var float $price */
    public $price;

    /** @var float $price */
    public $subscriptionPrice = 0;

    /** @var string $price */
    public $subscriptionFrequency = 'yearly';

    /** @var int $qty */
    public $qty = 0;

    /** @var array $versions */
    public $versions = [];

    /** @var string $currentVersion */
    public $currentVersion;

    /** @var bool $isUpgrade */
    public $isUpgrade = false;

    /** @var bool $publicDownload */
    public $publicDownload = false;

    /** @var array $downloadFileLocations */
    public $downloadFileLocations = [];

    /** @var string $licenseAgreementMarkdownFile */
    public $licenseAgreementMarkdownFile;

    /**
     * Gets the plan key
     * @return string
     */
    public function getPlanKey(): string
    {
        $price = $this->subscriptionPrice * 100;
        return $this->key . '__subscription-plan__' . $price;
    }
}
