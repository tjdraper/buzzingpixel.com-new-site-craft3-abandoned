<?php

namespace modules\store\models;

/**
 * Class StoreConfigModel
 */
class StoreConfigModel
{
    /** @var int $taxPercent */
    public $taxPercent;

    /** @var string $taxState */
    public $taxState;

    /** @var string $company */
    public $company;

    /** @var string $companyAddress */
    public $companyAddress;

    /** @var string $companyCity */
    public $companyCity;

    /** @var string $companyStateProvince */
    public $companyStateProvince;

    /** @var string $companyStateProvinceShort */
    public $companyStateProvinceShort;

    /** @var string $companyPostalCode */
    public $companyPostalCode;

    /** @var string $companyCountry */
    public $companyCountry;

    /** @var string $companyCountryShort */
    public $companyCountryShort;

    /** @var string $orderEmailTemplate */
    public $orderEmailTemplate;

    /** @var string $orderEmailAdmin */
    public $orderEmailAdmin;

    /** @var StoreProductModel[] $products */
    public $products = [];
}
