<?php

namespace modules\store\models;

use modules\store\Store;
use League\ISO3166\ISO3166;
use dev\twigextensions\StatesTwigExtension;

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

    /** @var bool $updateAccountInfo */
    public $updateAccountInfo;

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
     * @param bool $userDetailsOnly
     * @return array
     */
    public function getSaveData($includeId = true, $userDetailsOnly = false): array
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
            'updateAccountInfo' => $this->updateAccountInfo ? '1' : '0',
        ];

        if ($includeId && $this->id) {
            $saveData['id'] = $this->id;
        }

        if ($userDetailsOnly) {
            unset(
                $saveData['id'],
                $saveData['userId'],
                $saveData['sessionId'],
                $saveData['cartData']
            );
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

    /** @var float $subTotal */
    private $subTotal;

    /**
     * Gets subtotal
     * @return float
     */
    public function getSubTotal(): float
    {
        if ($this->subTotal === null) {
            $productModels = $this->getProductModels();

            $runningPrice = (float) 0;

            foreach ($productModels as $model) {
                $runningPrice += ((float) $model->price * $model->qty);
            }

            $this->subTotal = $runningPrice;
        }

        return $this->subTotal;
    }

    /** @var float $tax */
    private $tax;

    /**
     * Gets tax
     * @return float
     */
    public function getTax(): float
    {
        if ($this->tax === null) {
            $settings = Store::settings();

            $calcTax = $this->country === 'US' &&
                $this->stateProvince === $settings->taxState;

            $this->tax = (float) 0;

            if ($calcTax) {
                $multiplication = $this->getSubTotal() * $settings->taxPercent;
                $this->tax = (float) $multiplication / 100;
            }
        }

        return $this->tax;
    }

    /**
     * Gets total
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getSubTotal() + $this->getTax();
    }

    /**
     * Validates the cart for checkout
     */
    public function validateForCheckout(): array
    {
        $requiredProperties = [
            'phoneNumber',
            'country',
            'name',
            'address',
            'city',
            'stateProvince',
            'postalCode',
        ];

        $errors = [];

        foreach ($requiredProperties as $prop) {
            if (! $this->{$prop}) {
                $errors[$prop][] = 'This field is required';
            }
        }

        if ($this->country) {
            try {
                (new ISO3166())->alpha2($this->country);
            } catch (\Exception $e) {
                $errors['country'][] = 'You must specify a valid country';
            }
        }

        if ($this->country === 'US' &&
            $this->stateProvince &&
            ! isset((new StatesTwigExtension)->getStates()[$this->stateProvince])
        ) {
            $errors['stateProvince'][] = 'You must specify a valid U.S. state';
        }

        return $errors;
    }
}
