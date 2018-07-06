<?php

namespace modules\store\factories;

use modules\store\models\OrderItemModel;

/**
 * Class OrderItemsQueryFactory
 */
class OrderItemsQueryFactory extends AbstractQueryFactory
{
    protected $table = 'storeOrderItems';

    /**
     * Gets all matching results
     * @return OrderItemModel[]
     */
    public function all(): array
    {
        $queryResults = parent::all();

        $models = [];

        if (! $queryResults) {
            return $models;
        }

        foreach ($queryResults as $queryResult) {
            $models[] = $this->createOrderItemModelFromQueryResult(
                $queryResult
            );
        }

        return $models;
    }

    /**
     * Gets the first result
     * @return OrderItemModel|null
     */
    public function one()
    {
        $queryResult = parent::one();

        if (! $queryResult) {
            return null;
        }

        return $this->createOrderItemModelFromQueryResult($queryResult);
    }

    /**
     * Creates an order item from query result array
     * @param array $queryResult
     * @return OrderItemModel
     */
    private function createOrderItemModelFromQueryResult(
        array $queryResult
    ): OrderItemModel {
        $model = new OrderItemModel();

        $model->id = (int) $queryResult['id'];
        $model->userId = (int) $queryResult['userId'];
        $model->orderId = (int) $queryResult['orderId'];
        $model->key = (string) $queryResult['key'];
        $model->title = (string) $queryResult['title'];
        $model->version = (string) $queryResult['version'];
        $model->price = (int) $queryResult['price'];
        $model->originalPrice = (int) $queryResult['originalPrice'];
        $model->isUpgrade = (bool) ((int) $queryResult['isUpgrade']);
        $model->hasBeenUpgraded = (bool) ((int) $queryResult['hasBeenUpgraded']);
        $model->requiresSubscription = (bool) ((int) $queryResult['requiresSubscription']);
        $model->isSubscribed = (bool) ((int) $queryResult['isSubscribed']);
        $model->licenseKey = (string) $queryResult['licenseKey'];
        $model->notes = (string) $queryResult['notes'];
        $model->authorizedDomains = json_decode($queryResult['authorizedDomains'], true);
        $model->disabled = (bool) ((int) $queryResult['disabled']);

        if (! \is_array($model->authorizedDomains)) {
            $model->authorizedDomains = [];
        }

        return $model;
    }
}
