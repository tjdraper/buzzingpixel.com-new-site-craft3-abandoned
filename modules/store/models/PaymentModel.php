<?php

namespace modules\store\models;

/**
 * Class PaymentModel
 */
class PaymentModel
{
    /** @var string $cardNickName */
    public $cardNickName;

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
            'cardNickName',
            'cardNumber',
            'cvc',
            'expireMonth',
            'expireYear',
        ];
    }

    /**
     * Get cleaned card number
     * @return string
     */
    public function getCleanedCardNumber(): string
    {
        return preg_replace('/\s+/', '', $this->cardNumber);
    }

    /**
     * Gets display safe card number
     * @return string
     */
    public function getDisplaySafeCardNum(): string
    {
        $cardNum = $this->cardNumber;

        $last4 = substr($this->cardNumber, -4);

        $cardNum = preg_replace('/\S/', '*', substr($cardNum, 0, -4)) . $last4;

        return $cardNum;
    }

    /**
     * Gets the card nickname from the nickname property, or display safe card
     * num of no nickname is present
     * @return string
     */
    public function getCardNickName(): string
    {
        return $this->cardNickName ?: $this->getDisplaySafeCardNum();
    }

    /**
     * Validates that data is present and that expiration is not in past. This
     * method does not validate that the data is valid and chargeable card data.
     * Consider this method a pre-flight check
     * @return array
     */
    public function validateForCheckout(): array
    {
        $errors = [];

        $this->expireMonth = (int) $this->expireMonth;
        $this->expireYear = (int) $this->expireYear;

        foreach ($this->getProperties() as $prop) {
            if ($prop === 'cardNickName') {
                continue;
            }

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
