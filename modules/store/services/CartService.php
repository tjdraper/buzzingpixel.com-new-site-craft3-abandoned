<?php

namespace modules\store\services;

use craft\db\Connection as DBConnection;
use modules\store\factories\QueryFactory;
use modules\store\models\StoreConfigModel;

/**
 * Class CartService
 */
class CartService
{
    /** @var StoreConfigModel $configModel */
    private $configModel;

    /** @var string $userSessionId */
    private $userSessionId;

    /** @var int $craftUserId */
    private $craftUserId;

    /** @var QueryFactory $queryFactory */
    private $queryFactory;

    /** @var DBConnection $dbConnection */
    private $dbConnection;

    /** @var array $cartData */
    private $cartData = [];

    /** @var int $cartPrimaryKey */
    private $cartPrimaryKey;

    /**
     * CartService constructor
     * @param StoreConfigModel $configModel
     * @param string $userSessionId
     * @param int $craftUserId
     * @param QueryFactory $queryFactory
     * @param DBConnection $dbConnection
     * @throws \Exception
     */
    public function __construct(
        StoreConfigModel $configModel,
        string $userSessionId,
        int $craftUserId,
        QueryFactory $queryFactory,
        DBConnection $dbConnection
    ) {
        $this->configModel = $configModel;
        $this->userSessionId = $userSessionId;
        $this->craftUserId = $craftUserId ?: null;
        $this->queryFactory = $queryFactory;
        $this->dbConnection = $dbConnection;

        $this->mergeCarts();
        $this->setCart();
    }

    /**
     * Checks if multiple carts exists for this user and merges them
     * @throws \Exception
     */
    private function mergeCarts()
    {
        $count = (int) $this->queryFactory->getQuery()
            ->from('{{%storeCart}}')
            ->where("`sessionId` = '{$this->userSessionId}'")
            ->orWhere("`userId` = '{$this->craftUserId}'")
            ->count();

        if ($count < 2) {
            return;
        }

        $queryAll = $this->queryFactory->getQuery()
            ->from('{{%storeCart}}')
            ->where("`sessionId` = '{$this->userSessionId}'")
            ->orWhere("`userId` = '{$this->craftUserId}'")
            ->all();

        $ids = [];

        foreach ($queryAll as $query) {
            $ids[] = (int) $query['id'];
            $cartData = json_decode($query['cartData'], true);

            foreach ($cartData as $key => $total) {
                if (isset($this->cartData[$key])) {
                    $this->cartData[$key] += $total;
                    continue;
                }

                $this->cartData[$key] = $total;
            }
        }

        $this->dbConnection->createCommand()
            ->delete(
                '{{%storeCart}}',
                '`id` IN (' . implode(',', $ids) . ')'
            )
            ->execute();
    }

    /**
     * Sets the cart (it will be created if it doesn't exist)
     * @throws \Exception
     */
    private function setCart()
    {
        $cartQuery = $this->queryFactory->getQuery()
            ->from('{{%storeCart}}')
            ->where("`sessionId` = '{$this->userSessionId}'")
            ->orWhere("`userId` = '{$this->craftUserId}'")
            ->one();

        $updateCart = ! \is_array($cartQuery);

        if ($cartQuery) {
            $this->cartPrimaryKey = (int) $cartQuery['id'];

            if (((int) $cartQuery['userId']) !== $this->craftUserId) {
                $updateCart = true;
            }

            if ($cartQuery['sessionId'] !== $this->userSessionId) {
                $updateCart = true;
            }

            $this->cartData = json_decode($cartQuery['cartData'], true) ?? [];
        }

        if ($updateCart) {
            $this->dbConnection->createCommand()->upsert(
                '{{%storeCart}}',
                [
                    'id' => $this->cartPrimaryKey,
                    'userId' => $this->craftUserId,
                    'sessionId' => $this->userSessionId,
                    'cartData' => json_encode($this->cartData),
                ]
            )
            ->execute();
        }

        if (! $cartQuery) {
            $this->setCart();
        }
    }

    /**
     * Creates the cart
     * @throws \Exception
     */
    private function updateCart()
    {
        $this->dbConnection->createCommand()->upsert(
            '{{%storeCart}}',
            [
                'id' => $this->cartPrimaryKey,
                'userId' => $this->craftUserId,
                'sessionId' => $this->userSessionId,
                'cartData' => json_encode($this->cartData),
            ]
        )
        ->execute();
    }

    /**
     * Adds a product to the cart
     * @param string $productKey
     * @return bool `(bool) true` if product exists. `(bool) false` if not
     * @throws \Exception
     */
    public function add(string $productKey): bool
    {
        if (! isset($this->configModel->products[$productKey])) {
            return false;
        }

        if (! isset($this->cartData[$productKey])) {
            $this->cartData[$productKey] = 1;
            $this->updateCart();
            return true;
        }

        $this->cartData[$productKey]++;
        $this->updateCart();
        return true;
    }

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
}
