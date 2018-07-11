<?php

namespace modules\store\services;

use modules\store\models\CartModel;
use Ramsey\Uuid\UuidFactoryInterface;
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

    /** @var string $cartIdToken */
    private $cartIdToken;

    /** @var int $craftUserId */
    private $craftUserId;

    /** @var QueryFactory $queryFactory */
    private $queryFactory;

    /** @var DBConnection $dbConnection */
    private $dbConnection;

    /** @var CookieService $cookieService */
    private $cookieService;

    /** @var UuidFactoryInterface $uuidFactory */
    private $uuidFactory;

    /**
     * CartService constructor
     * @param StoreConfigModel $configModel
     * @param CartModel $cartModel
     * @param int $craftUserId
     * @param QueryFactory $queryFactory
     * @param DBConnection $dbConnection
     * @param CookieService $cookieService
     * @param UuidFactoryInterface $uuidFactory
     * @throws \Exception
     */
    public function __construct(
        StoreConfigModel $configModel,
        CartModel $cartModel,
        int $craftUserId,
        QueryFactory $queryFactory,
        DBConnection $dbConnection,
        CookieService $cookieService,
        UuidFactoryInterface $uuidFactory
    ) {
        $this->configModel = $configModel;
        $this->cartModel = $cartModel;
        $this->craftUserId = $craftUserId ?: null;
        $this->queryFactory = $queryFactory;
        $this->dbConnection = $dbConnection;
        $this->cookieService = $cookieService;
        $this->uuidFactory = $uuidFactory;

        $this->cartIdToken = $this->getOrGenerateCartIdToken();

        $this->mergeCarts();
        $this->setCart();
    }

    /**
     * Gets cart ID token from cookie or generates it
     * @return string
     * @throws \Exception
     */
    public function getOrGenerateCartIdToken(): string
    {
        $cookie = $this->cookieService->get('storeCartIdToken');

        if (! $cookie) {
            $cookie = $this->cookieService->createCookie(
                'storeCartIdToken',
                $this->uuidFactory->uuid4()->toString()
            );
        }

        $cookie->expire = strtotime('+20 years');

        $this->cookieService->add($cookie);

        return $cookie->value;
    }

    /**
     * Checks if multiple carts exists for this user and merges them
     * @throws \Exception
     */
    private function mergeCarts()
    {
        $count = (int) $this->queryFactory->getQuery()
            ->from('{{%storeCart}}')
            ->where("`sessionId` = '{$this->cartIdToken}'")
            ->orWhere("`userId` = '{$this->craftUserId}'")
            ->count();

        if ($count < 2) {
            return;
        }

        $queryAll = $this->queryFactory->getQuery()
            ->from('{{%storeCart}}')
            ->where("`sessionId` = '{$this->cartIdToken}'")
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
            ->where("`sessionId` = '{$this->cartIdToken}'")
            ->orWhere("`userId` = '{$this->craftUserId}'")
            ->one();

        $updateCart = ! \is_array($cartQuery);

        if ($cartQuery) {
            if (((int) $cartQuery['userId']) !== $this->craftUserId) {
                $updateCart = true;
            }

            if ($cartQuery['sessionId'] !== $this->cartIdToken) {
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

        if ($this->cartModel->sessionId !== $this->cartIdToken) {
            $updateCart = true;
            $this->cartModel->sessionId = $this->cartIdToken;
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
    public function updateCart()
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
     * Updates an item in the cart
     * @param string $productKey
     * @param int $qty
     * @return bool `(bool) true` if product exists. `(bool) false` if not
     * @throws \Exception
     */
    public function updateItemQty(string $productKey, int $qty): bool
    {
        if (! isset($this->configModel->products[$productKey])) {
            return false;
        }

        if ($qty < 1) {
            return $this->remove($productKey);
        }

        $this->cartModel->cartData[$productKey] = $qty;

        $this->updateCart();
        return true;
    }

    /**
     * Removes a product from the cart
     * @param string $productKey
     * @return bool `(bool) true` if product exists. `(bool) false` if not
     * @throws \Exception
     */
    public function remove(string $productKey): bool
    {
        if (! isset($this->configModel->products[$productKey])) {
            return false;
        }

        if (! isset($this->cartModel->cartData[$productKey])) {
            return true;
        }

        unset($this->cartModel->cartData[$productKey]);
        $this->updateCart();
        return true;
    }

    /**
     * Clears the cart
     * @throws \Exception
     */
    public function clearCart()
    {
        $this->cartModel->cartData = [];
        $this->cartModel->paymentMethod = null;
        $this->cartModel->country = null;
        $this->cartModel->name = null;
        $this->cartModel->company = null;
        $this->cartModel->address = null;
        $this->cartModel->addressContinued = null;
        $this->cartModel->city = null;
        $this->cartModel->stateProvince = null;
        $this->cartModel->postalCode = null;
        $this->cartModel->updateAccountInfo = 0;
        $this->updateCart();
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
