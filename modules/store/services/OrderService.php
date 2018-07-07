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
use modules\store\factories\OrderQueryFactory;
use modules\store\factories\OrderItemsQueryFactory;

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

    /** @var OrderItemsQueryFactory $orderItemsQueryFactory */
    private $orderItemsQueryFactory;

    /** @var OrderQueryFactory $orderQueryFactory */
    private $orderQueryFactory;

    /**
     * OrderService constructor
     * @param DBConnection $dbConnection
     * @param QueryFactory $queryFactory
     * @param UuidFactoryInterface $uuidFactory
     * @param OrderItemsQueryFactory $orderItemsQueryFactory
     * @param OrderQueryFactory $orderQueryFactory
     */
    public function __construct(
        DBConnection $dbConnection,
        QueryFactory $queryFactory,
        UuidFactoryInterface $uuidFactory,
        OrderItemsQueryFactory $orderItemsQueryFactory,
        OrderQueryFactory $orderQueryFactory
    ) {
        $this->dbConnection = $dbConnection;
        $this->queryFactory = $queryFactory;
        $this->uuidFactory = $uuidFactory;
        $this->orderItemsQueryFactory = $orderItemsQueryFactory;
        $this->orderQueryFactory = $orderQueryFactory;
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
        return $this->orderItemsQueryFactory->getNewFactory()
            ->where('orderId', $orderId)
            ->all();
    }

    /**
     * Gets most recent order for user
     * @param int $userId
     * @return OrderModel
     */
    public function getMostRecentUserOrder(int $userId): OrderModel
    {
        return $this->orderQueryFactory->getNewFactory()
            ->where('userId', $userId)
            ->orderBy('dateCreated', 'desc')
            ->one();
    }
}
