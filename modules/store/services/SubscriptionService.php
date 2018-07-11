<?php

namespace modules\store\services;

use dev\models\UserModel;
use modules\store\models\OrderItemModel;
use Stripe\Subscription as StripeSubscription;

/**
 * Class SubscriptionService
 */
class SubscriptionService
{
    /** @var StripeSubscription $stripeSubscription */
    private $stripeSubscription;

    /**
     * SubscriptionService constructor
     * @param StripeSubscription $stripeSubscription
     */
    public function __construct(StripeSubscription $stripeSubscription)
    {
        $this->stripeSubscription = $stripeSubscription;
    }

    /**
     * Start subscriptions for order items
     * @param OrderItemModel[] $orderItems
     * @param UserModel $userModel
     * @throws \Exception
     */
    public function startSubscriptionsForOrderItems(
        array $orderItems,
        UserModel $userModel
    ) {
        $date = new \DateTime();
        $date->add(new \DateInterval('P1Y'));
        $oneYearTimestamp = $date->getTimestamp();

        foreach ($orderItems as $orderItem) {
            if (! $orderItem instanceof OrderItemModel ||
                ! $orderItem->requiresSubscription
            ) {
                continue;
            }

            $productModel = $orderItem->getStoreProductModel();

            $this->stripeSubscription::create([
                'customer' => $userModel->stripeCustomerId,
                'billing' => 'charge_automatically',
                'billing_cycle_anchor' => $oneYearTimestamp,
                'items' => [
                    [
                        'plan' => $productModel->getPlanKey(),
                        'quantity' => 1,
                    ]
                ],
                'metadata' => [
                    'itemId' => $orderItem->id,
                    'orderId' => $orderItem->orderId,
                    'title' => $orderItem->title,
                    'licenseKey' => $orderItem->licenseKey,
                ],
                'prorate' => false,
            ]);
        }
    }
}
