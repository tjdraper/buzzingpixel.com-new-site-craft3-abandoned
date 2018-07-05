<?php

namespace modules\store\services;

use yii\helpers\Console;
use Stripe\Plan as StripePlan;
use Stripe\Product as StripeProduct;
use modules\store\models\StoreConfigModel;
use modules\store\models\StoreProductModel;

/**
 * Class SyncStripeProductsService
 */
class SyncStripeProductsService
{
    /** @var StoreConfigModel $storeConfigModel */
    private $storeConfigModel;

    /** @var StripeProduct $stripeProduct */
    private $stripeProduct;

    /** @var StripePlan $stripePlan */
    private $stripePlan;

    /**
     * SyncStripeProductsService constructor
     * @param StoreConfigModel $storeConfigModel
     * @param StripeProduct $stripeProduct
     * @param StripePlan $stripePlan
     */
    public function __construct(
        StoreConfigModel $storeConfigModel,
        StripeProduct $stripeProduct,
        StripePlan $stripePlan
    ) {
        $this->storeConfigModel = $storeConfigModel;
        $this->stripeProduct = $stripeProduct;
        $this->stripePlan = $stripePlan;
    }

    /**
     * Runs product sync with stripe
     * @param bool $updateCLIProgress
     */
    public function __invoke(bool $updateCLIProgress = true)
    {
        $this->run($updateCLIProgress);
    }

    /**
     * Runs product sync with stripe
     * @param bool $updateCLIProgress
     */
    public function run($updateCLIProgress)
    {
        $products = $this->storeConfigModel->products;

        $total = \count($products);

        if ($updateCLIProgress) {
            Console::startProgress(0, $total);
        }

        $counter = 0;

        foreach ($products as $productModel) {
            $this->addUpdateStripeProduct($productModel);

            if ($productModel->subscriptionPrice) {
                $this->addUpdateStripePlan($productModel);
            }

            if (! $updateCLIProgress) {
                continue;
            }

            $counter++;

            Console::updateProgress($counter, $total);
        }

        if (! $updateCLIProgress) {
            return;
        }

        Console::endProgress();
    }

    /**
     * Adds or updates a Stripe product
     * @param StoreProductModel $productModel
     */
    public function addUpdateStripeProduct(StoreProductModel $productModel)
    {
        try {
            $stripeProduct = $this->stripeProduct::retrieve($productModel->key);
        } catch (\Exception $e) {
            $stripeProduct = null;
        }

        $metaData = [
            'productKey' => $productModel->key,
            'productTitle' => $productModel->title,
            'productUrl' => $productModel->url,
            'productPrice' => $productModel->price,
            'productSubscriptionPrice' => $productModel->subscriptionPrice,
            'productSubscriptionFrequency' => $productModel->subscriptionFrequency,
        ];

        if (! $stripeProduct) {
            $this->stripeProduct::create([
                'id' => $productModel->key,
                'name' => $productModel->title,
                'type' => 'service',
                'metadata' => $metaData,
            ]);

            return;
        }

        /** @var StripeProduct $stripeProduct */

        $stripeProduct->name = $productModel->title;
        $stripeProduct->metadata = $metaData;

        $stripeProduct->save();
    }

    /**
     * Adds or updates a Stripe plan for a product
     * @param StoreProductModel $productModel
     */
    public function addUpdateStripePlan(StoreProductModel $productModel)
    {
        try {
            $stripePlan = $this->stripePlan::retrieve(
                $productModel->getPlanKey()
            );
        } catch (\Exception $e) {
            $stripePlan = null;
        }

        $nickName = $productModel->title . ' $' .
            $productModel->subscriptionPrice . ' Subscription Plan';

        if (! $stripePlan) {
            $this->stripePlan::create([
                'id' => $productModel->getPlanKey(),
                'currency' => 'usd',
                'interval' => 'year',
                'product' => $productModel->key,
                'amount' => $productModel->subscriptionPrice * 100,
                'interval_count' => 1,
                'nickname' => $nickName,
            ]);

            return;
        }

        /** @var StripePlan $stripePlan */

        // $stripePlan->product = $productModel->key;
        $stripePlan->nickname = $nickName;

        $stripePlan->save();
    }
}
