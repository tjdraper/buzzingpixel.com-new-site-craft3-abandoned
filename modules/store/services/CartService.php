<?php

namespace modules\store\services;

use modules\store\models\CartModel;
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

    /** @var CartModel $cartModel */
    private $cartModel;

    /** @var string $userSessionId */
    private $userSessionId;

    /** @var int $craftUserId */
    private $craftUserId;

    /** @var QueryFactory $queryFactory */
    private $queryFactory;

    /** @var DBConnection $dbConnection */
    private $dbConnection;

    /**
     * CartService constructor
     * @param StoreConfigModel $configModel
     * @param CartModel $cartModel
     * @param string $userSessionId
     * @param int $craftUserId
     * @param QueryFactory $queryFactory
     * @param DBConnection $dbConnection
     * @throws \Exception
     */
    public function __construct(
        StoreConfigModel $configModel,
        CartModel $cartModel,
        string $userSessionId,
        int $craftUserId,
        QueryFactory $queryFactory,
        DBConnection $dbConnection
    ) {
        $this->configModel = $configModel;
        $this->cartModel = $cartModel;
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

        $lastDateUpdated = 0;

        foreach ($queryAll as $query) {
            $query = \is_array($query) ? $query : [];
            $ids[] = (int) $query['id'];
            $cartData = json_decode($query['cartData'], true) ?? [];
            $dateUpdated = (new \DateTime($query['dateUpdated']))->getTimestamp();

            foreach ($cartData as $key => $total) {
                if (isset($this->cartModel->cartData[$key])) {
                    $this->cartModel->cartData[$key] += $total;
                    continue;
                }

                $this->cartModel->cartData[$key] = $total;
            }

            if ($dateUpdated <= $lastDateUpdated) {
                continue;
            }

            unset($query['cartData']);

            foreach ($query as $key => $val) {
                $this->cartModel->{$key} = $val;
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
            if (((int) $cartQuery['userId']) !== $this->craftUserId) {
                $updateCart = true;
            }

            if ($cartQuery['sessionId'] !== $this->userSessionId) {
                $updateCart = true;
            }

            $this->cartModel->cartData = json_decode($cartQuery['cartData'], true) ?? [];

            unset($cartQuery['cartData']);

            foreach ($cartQuery as $key => $val) {
                $this->cartModel->{$key} = $val;
            }
        }

        if ($this->cartModel->userId !== $this->craftUserId) {
            $updateCart = true;
            $this->cartModel->userId = $this->craftUserId;
        }

        if ($this->cartModel->sessionId !== $this->userSessionId) {
            $updateCart = true;
            $this->cartModel->sessionId = $this->userSessionId;
        }

        if ($updateCart) {
            $this->updateCart();
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
            $this->cartModel->getSaveData()
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

        if (! isset($this->cartModel->cartData[$productKey])) {
            $this->cartModel->cartData[$productKey] = 1;
            $this->updateCart();
            return true;
        }

        $this->cartModel->cartData[$productKey]++;
        $this->updateCart();
        return true;
    }

    /**
     * Gets the cart count
     * @return int
     */
    public function count(): int
    {
        return $this->cartModel->count();
    }

    /**
     * Gets the cart model
     * @return CartModel
     */
    public function getCartModel(): CartModel
    {
        return $this->cartModel;
    }
}
