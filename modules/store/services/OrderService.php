<?php

namespace modules\store\services;

use Stripe\ApiResource;
use modules\store\models\CartModel;
use modules\store\models\OrderModel;
use Ramsey\Uuid\UuidFactoryInterface;
use yii\db\Exception as YiiDbException;
use craft\db\Connection as DBConnection;
use modules\store\factories\QueryFactory;
use \modules\store\models\OrderItemModel;
use modules\store\models\StoreProductModel;

/**
 * Class OrderService
 */
class OrderService
{
    /** @var DBConnection $dbConnection */
    private $dbConnection;

    /** @var QueryFactory $queryFactory */
    public $queryFactory;

    /** @var UuidFactoryInterface $uuidFactory */
    private $uuidFactory;

    /**
     * OrderService constructor
     * @param DBConnection $dbConnection
     * @param QueryFactory $queryFactory
     * @param UuidFactoryInterface $uuidFactory
     */
    public function __construct(
        DBConnection $dbConnection,
        QueryFactory $queryFactory,
        UuidFactoryInterface $uuidFactory
    ) {
        $this->dbConnection = $dbConnection;
        $this->queryFactory = $queryFactory;
        $this->uuidFactory = $uuidFactory;
    }

    /**
     * Creates an order from a successful transaction
     * @param ApiResource $charge
     * @param CartModel $cartModel
     * @return int The insert ID
     * @throws \Exception
     * @throws \Throwable
     */
    public function createOrderFromCharge(
        ApiResource $charge,
        CartModel $cartModel
    ): int {
        $transaction = $this->dbConnection->beginTransaction();

        try {
            $numRows = $this->dbConnection->createCommand()
                ->insert(
                    '{{%storeOrders}}',
                    [
                        'userId' => $cartModel->userId,
                        'transactionId' => $charge->id,
                        'transactionAmount' => $charge->amount,
                        'balanceTransactionId' => $charge->balance_transaction,
                        'transactionCaptured' => $charge->captured,
                        'transactionCreated' => $charge->created,
                        'transactionCurrency' => $charge->currency,
                        'transactionDescription' => $charge->description,
                        'subTotal' => $cartModel->getSubTotal(),
                        'tax' => $cartModel->getTax(),
                        'total' => $cartModel->getTotal(),
                        'name' => $cartModel->name,
                        'company' => $cartModel->company,
                        'phoneNumber' => $cartModel->phoneNumber,
                        'country' => $cartModel->country,
                        'address' => $cartModel->address,
                        'addressContinued' => $cartModel->addressContinued,
                        'city' => $cartModel->city,
                        'stateProvince' => $cartModel->stateProvince,
                        'postalCode' => $cartModel->postalCode,
                    ]
                )
                ->execute();

            if ($numRows < 1) {
                throw new YiiDbException('Unable to create order');
            }

            $orderId = (int) $this->dbConnection->getLastInsertID();

            foreach ($cartModel->getProductModels() as $productModel) {
                for ($i = 0; $i < $productModel->qty; $i++) {
                    $this->addProductToOrder(
                        $productModel,
                        $orderId,
                        $cartModel->userId
                    );
                }
            }

            $transaction->commit();

            return $orderId;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Adds a product to an order
     * @param StoreProductModel $productModel
     * @param int $orderId
     * @param int $userId
     * @throws YiiDbException
     */
    public function addProductToOrder(
        StoreProductModel $productModel,
        int $orderId,
        int $userId
    ) {
        $numRows = $this->dbConnection->createCommand()
            ->insert(
                '{{%storeOrderItems}}',
                [
                    'userId' => $userId,
                    'orderId' => $orderId,
                    'key' => $productModel->key,
                    'title' => $productModel->title,
                    'version' => $productModel->currentVersion,
                    'price' => $productModel->price,
                    'originalPrice' => $productModel->price,
                    'isUpgrade' => $productModel->isUpgrade ? 1 : 0,
                    'hasBeenUpgraded' => 0,
                    'requiresSubscription' => $productModel->subscriptionPrice > 0 ? 1 : 0,
                    'isSubscribed' => 0,
                    'licenseKey' => $this->uuidFactory->uuid4()->toString(),
                    'notes' => '',
                    'authorizedDomains' => '',
                    'disabled' => 0,
                ]
            )
        ->execute();

        if ($numRows < 1) {
            throw new YiiDbException('Unable to create order');
        }
    }

    /**
     * Gets order items by order ID
     * @param int $orderId
     * @return OrderItemModel[]
     */
    public function getOrderItemsByOrderId(int $orderId): array
    {
        $query = $this->queryFactory->getQuery()->from('{{%storeOrderItems}}')
            ->where("`orderId` = '{$orderId}'")
            ->all();

        if (! $query) {
            return [];
        }

        $models = [];

        foreach ($query as $item) {
            $model = new OrderItemModel();

            $model->id = (int) $item['id'];
            $model->userId = (int) $item['userId'];
            $model->orderId = (int) $item['orderId'];
            $model->key = (string) $item['key'];
            $model->title = (string) $item['title'];
            $model->version = (string) $item['version'];
            $model->price = (int) $item['price'];
            $model->originalPrice = (int) $item['originalPrice'];
            $model->isUpgrade = (bool) ((int) $item['isUpgrade']);
            $model->hasBeenUpgraded = (bool) ((int) $item['hasBeenUpgraded']);
            $model->requiresSubscription = (bool) ((int) $item['requiresSubscription']);
            $model->isSubscribed = (bool) ((int) $item['isSubscribed']);
            $model->licenseKey = (string) $item['licenseKey'];
            $model->notes = (string) $item['notes'];
            $model->authorizedDomains = json_decode($item['authorizedDomains'], true);
            $model->disabled = (bool) ((int) $item['disabled']);

            if (! \is_array($model->authorizedDomains)) {
                $model->authorizedDomains = [];
            }

            $models[] = $model;
        }

        return $models;
    }

    /**
     * Gets most recent order for user
     * @param int $userId
     * @return OrderModel
     */
    public function getMostRecentUserOrder(int $userId): OrderModel
    {
        $query = $this->queryFactory->getQuery()->from('{{%storeOrders}}')
            ->where("`userId` = '{$userId}'")
            ->orderBy('`dateCreated` desc')
            ->one();

        $model = new OrderModel();

        if (! $query) {
            return $model;
        }

        $model->id = (int) $query['id'];
        $model->userId = (int) $query['userId'];
        $model->transactionId = $query['transactionId'];
        $model->transactionAmount = (int) $query['transactionAmount'];
        $model->balanceTransactionId = $query['balanceTransactionId'];
        $model->transactionCaptured = $query['transactionCaptured'] === '1' ||
            $query['transactionCaptured'] === 1;
        $model->transactionCreated = (new \DateTime())->setTimestamp(
            $query['transactionCreated']
        );
        $model->transactionCurrency = $query['transactionCurrency'];
        $model->transactionDescription = $query['transactionDescription'];
        $model->subTotal = (float) $query['subTotal'];
        $model->total = (float) $query['total'];
        $model->tax = (float) $query['tax'];
        $model->name = $query['name'];
        $model->company = $query['company'];
        $model->phoneNumber = $query['phoneNumber'];
        $model->country = $query['country'];
        $model->address = $query['address'];
        $model->addressContinued = $query['addressContinued'];
        $model->city = $query['city'];
        $model->stateProvince = $query['stateProvince'];
        $model->postalCode = $query['postalCode'];

        return $model;
    }
}
