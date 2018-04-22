<?php

namespace modules\store\models;

/**
 * Class StoreProductModel
 */
class StoreProductModel
{
    /** @var string $title */
    public $title;

    /** @var string $url */
    public $url;

    /** @var int $price */
    public $price;

    /** @var array $versions */
    public $versions = [];

    /** @var bool $publicDownload */
    public $publicDownload = false;

    /** @var array $downloadFileLocations */
    public $downloadFileLocations = [];
}
