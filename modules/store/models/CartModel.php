<?php

namespace modules\store\models;

use modules\store\Store;
use modules\store\models\StoreProductModel;

/**
 * Class CartModel
 */
class CartModel
{
    /** @var int $id */
    public $id;

    /** @var int $userId */
    public $userId;

    /** @var string $sessionId */
    public $sessionId;

    /** @var array $cartData */
    public $cartData = [];

    /** @var string $phoneNumber */
    public $phoneNumber;

    /** @var string $country */
    public $country;

    /** @var string $name */
    public $name;

    /** @var string $company */
    public $company;

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

    /** @var \DateTime $dateCreated */
    public $dateCreated;

    /** @var \DateTime $dateUpdated */
    public $dateUpdated;

    /** @var string $uid */
    public $uid;

    /**
     * Gets the cart count
     * @return int
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->cartData as $itemCount) {
            $count += $itemCount;
        }

        return $count;
    }

    /**
     * Gets database save data
     * @param bool $includeId
     * @return array
     */
    public function getSaveData($includeId = true): array
    {
        $saveData = [
            'userId' => $this->userId,
            'sessionId' => $this->sessionId,
            'cartData' => json_encode($this->cartData),
            'phoneNumber' => $this->phoneNumber,
            'country' => $this->country,
            'name' => $this->name,
            'company' => $this->company,
            'address' => $this->address,
            'addressContinued' => $this->addressContinued,
            'city' => $this->city,
            'stateProvince' => $this->stateProvince,
            'postalCode' => $this->postalCode,
        ];

        if ($includeId && $this->id) {
            $saveData['id'] = $this->id;
        }

        return $saveData;
    }

    /**
     * Gets the product models in cart
     * @return StoreProductModel[]
     */
    public function getProductModels(): array
    {
        $models = [];

        $products = Store::settings()->products;

        foreach ($this->cartData as $key => $qty) {
            $models[$key] = $products[$key];
            $models[$key]->qty = $qty;
        }

        return $models;
    }
}
