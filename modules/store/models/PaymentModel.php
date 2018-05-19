<?php

namespace modules\store\models;

/**
 * Class PaymentModel
 */
class PaymentModel
{
    /** @var string $cardNumber */
    public $cardNumber;

    /** @var string $cvc */
    public $cvc;

    /** @var int $expireMonth */
    public $expireMonth;

    /** @var int $expireYear */
    public $expireYear;

    /**
     * Gets the properties
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'cardNumber',
            'cvc',
            'expireMonth',
            'expireYear',
        ];
    }

    /**
     * Validates that data is present and that expiration is not in past. This
     * method does not validate that the data is valid and chargeable card data.
     * Consider this method a pre-flight check
     */
    public function validateForCheckout()
    {
        $errors = [];

        $this->expireMonth = (int) $this->expireMonth;
        $this->expireYear = (int) $this->expireYear;

        foreach ($this->getProperties() as $prop) {
            if (! $this->{$prop}) {
                $errors[$prop][] = 'This field is required';
            }
        }

        if (isset($errors['expireMonth'], $errors['expireYear'])) {
            unset($errors['expireMonth'], $errors['expireYear']);
            $errors['expiration'][] = 'Expiration date is required';
        }

        $currentTime = new \DateTime();
        $month = (int) $currentTime->format('n');
        $year = (int) $currentTime->format('Y');

        if (($this->expireYear && $this->expireYear < $year) ||
            ($this->expireYear === $year && $this->expireMonth < $month)
        ) {
            $errors['expiration'][] = 'The expiration date must not be in the past';
        }

        return $errors;
    }
}
