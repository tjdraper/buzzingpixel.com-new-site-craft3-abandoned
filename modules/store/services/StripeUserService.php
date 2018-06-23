<?php

namespace modules\store\services;

use dev\models\UserModel;
use dev\services\UserService;
use modules\store\models\CardModel;
use modules\store\models\CartModel;
use yii\db\Exception as DbException;
use Stripe\Customer as StripeCustomer;
use \modules\store\models\PaymentModel;
use modules\store\factories\QueryFactory;

/**
 * Class StripeUserService
 */
class StripeUserService
{
    /** @var StripeCustomer $stripeCustomer */
    private $stripeCustomer;

    /** @var UserService $userService */
    private $userService;

    /** @var QueryFactory $queryFactory */
    public $queryFactory;

    /**
     * StripeUserService constructor
     * @param StripeCustomer $stripeCustomer
     * @param UserService $userService
     * @param QueryFactory $queryFactory
     */
    public function __construct(
        StripeCustomer $stripeCustomer,
        UserService $userService,
        QueryFactory $queryFactory
    ) {
        $this->stripeCustomer = $stripeCustomer;
        $this->userService = $userService;
        $this->queryFactory = $queryFactory;
    }

    /**
     * Creates a Stripe user
     * @param UserModel $userModel
     * @throws \LogicException
     * @throws \ReflectionException
     * @throws DbException
     * @throws \Exception
     */
    public function touchStripeUser(UserModel $userModel)
    {
        $metaData = [
            'displayName' => $userModel->displayName,
            'billingPhoneNumber' => $userModel->billingPhoneNumber,
            'billingCountry' => $userModel->billingCountry,
            'billingName' => $userModel->billingName,
            'billingCompany' => $userModel->billingCompany,
            'billingAddress' => $userModel->billingAddress,
            'billingAddressContinued' => $userModel->billingAddressContinued,
            'billingCity' => $userModel->billingCity,
            'billingStateProvince' => $userModel->billingStateProvince,
            'billingPostalCode' => $userModel->billingPostalCode,
        ];

        if (! $userModel->stripeCustomerId) {
            $createResponse = $this->stripeCustomer::create([
                'description' => 'BuzzingPixel.com customer',
                'email' => $userModel->emailAddress,
                'metadata' => $metaData,
            ]);

            if (! $createResponse || ! isset($createResponse->id)) {
                throw new \LogicException('Unable to create customer on Stripe');
            }

            $userModel->stripeCustomerId = $createResponse->id;

            $this->userService->saveUser($userModel);

            return;
        }

        $customer = $this->stripeCustomer::retrieve($userModel->stripeCustomerId);
        $customer->description = 'BuzzingPixel.com customer';
        $customer->email = $userModel->emailAddress;
        $customer->metadata = $metaData;
        $customer->save();
    }

    /**
     * Gets user cards
     * @param UserModel $userModel
     * @throws \LogicException
     * @throws \ReflectionException
     * @return CardModel[]
     */
    public function getUserCards(UserModel $userModel): array
    {
        if (! $userModel->getProperty('userId') ||
            ! $userModel->getProperty('stripeCustomerId')
        ) {
            throw new \LogicException('No user id found');
        }

        $query = $this->queryFactory->getQuery()->from('{{%storeCards}}')
            ->where("`userId` = '{$userModel->getProperty('userId')}'")
            ->all();

        if (! $query) {
            return [];
        }

        $cards = [];

        foreach ($query as $item) {
            $cardModel = new CardModel();

            $cardModel->id = $item['id'];
            $cardModel->userId = $item['userId'];
            $cardModel->stripeCardId = $item['stripeCardId'];
            $cardModel->cardNickName = $item['cardNickName'];

            $cards[] = $cardModel;
        }

        /** @var CardModel[] $cards */

        /** @var StripeCustomer $customer */
        $customer = $this->stripeCustomer::retrieve(
            $userModel->getProperty('stripeCustomerId')
        );

        $userCards = $customer->sources->all(['object' => 'card'])->data;

        foreach ($cards as $key => $card) {
            $stripeCard = null;

            foreach ($userCards as $userCard) {
                if ($card->stripeCardId !== $userCard->id) {
                    continue;
                }

                $stripeCard = $userCard;

                break;
            }

            if (! $stripeCard) {
                unset($cards[$key]);
                continue;
            }

            $card->populateFromStripeCardObject($stripeCard);
        }

        return array_values($cards);
    }

    /**
     * Add user card
     * @param UserModel $userModel
     * @param PaymentModel $paymentModel
     * @param CartModel $cartModel
     * @return CardModel
     * @throws \Exception
     */
    public function addUserCard(
        UserModel $userModel,
        PaymentModel $paymentModel,
        CartModel $cartModel
    ): CardModel {
        /** @var StripeCustomer $customer */
        $customer = $this->stripeCustomer::retrieve(
            $userModel->getProperty('stripeCustomerId')
        );

        $resp = $customer->sources->create([
            'source' => [
                'object' => 'card',
                'number' => $paymentModel->getCleanedCardNumber(),
                'exp_month' => $paymentModel->expireMonth,
                'exp_year' => $paymentModel->expireYear,
                'cvc' => $paymentModel->cvc,
                'name' => $cartModel->name,
                'address_line1' => $cartModel->address,
                'address_line2' => $cartModel->addressContinued,
                'address_city' => $cartModel->city,
                'address_state' => $cartModel->stateProvince,
                'address_zip' => $cartModel->postalCode,
                'address_country' => $cartModel->country,
                'metadata' => [
                    'cardNickName' => $paymentModel->getCardNickName(),
                ],
            ]
        ]);

        if (! $resp || ! isset($resp->id) || ! $resp->id) {
            throw new \LogicException('Unable to attach card to customer on Stripe');
        }

        $cardModel = new CardModel($resp, $userModel);

        $this->userService->saveUserCard($cardModel);

        return $cardModel;
    }
}
