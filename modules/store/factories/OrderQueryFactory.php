<?php

namespace modules\store\factories;

use modules\store\models\OrderModel;

/**
 * Class OrderQueryFactory
 */
class OrderQueryFactory extends AbstractQueryFactory
{
    protected $table = 'storeOrders';

    /**
     * Gets all matching results
     * @return OrderModel[]
     */
    public function all(): array
    {
        $queryResults = parent::all();

        $models = [];

        if (! $queryResults) {
            return $models;
        }

        foreach ($queryResults as $queryResult) {
            $models[] = $this->createOrderModelFromQueryResult($queryResult);
        }

        return $models;
    }

    /**
     * Gets the first result
     * @return OrderModel|null
     */
    public function one()
    {
        $queryResult = parent::one();

        if (! $queryResult) {
            return null;
        }

        return $this->createOrderModelFromQueryResult($queryResult);
    }

    /**
     * Creates an order model from query result array
     * @param array $queryResult
     * @return OrderModel
     */
    private function createOrderModelFromQueryResult(
        array $queryResult
    ): OrderModel {
        $model = new OrderModel();

        $model->id = (int) $queryResult['id'];
        $model->userId = (int) $queryResult['userId'];
        $model->transactionId = $queryResult['transactionId'];
        $model->transactionAmount = (int) $queryResult['transactionAmount'];
        $model->balanceTransactionId = $queryResult['balanceTransactionId'];
        $model->transactionCaptured = $queryResult['transactionCaptured'] === '1' ||
            $queryResult['transactionCaptured'] === 1;
        $model->transactionCreated = (new \DateTime())->setTimestamp(
            $queryResult['transactionCreated']
        );
        $model->transactionCurrency = $queryResult['transactionCurrency'];
        $model->transactionDescription = $queryResult['transactionDescription'];
        $model->subTotal = (float) $queryResult['subTotal'];
        $model->total = (float) $queryResult['total'];
        $model->tax = (float) $queryResult['tax'];
        $model->name = $queryResult['name'];
        $model->company = $queryResult['company'];
        $model->country = $queryResult['country'];
        $model->address = $queryResult['address'];
        $model->addressContinued = $queryResult['addressContinued'];
        $model->city = $queryResult['city'];
        $model->stateProvince = $queryResult['stateProvince'];
        $model->postalCode = $queryResult['postalCode'];

        return $model;
    }
}
