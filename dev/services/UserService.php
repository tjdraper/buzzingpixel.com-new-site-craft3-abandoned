<?php

namespace dev\services;

use craft\web\User;
use dev\models\UserModel;
use modules\store\models\CardModel;
use modules\store\models\CartModel;
use yii\db\Exception as DbException;
use craft\db\Connection as DBConnection;
use modules\store\factories\QueryFactory;

/**
 * Class TypesetService
 */
class UserService
{
    /** @var User $craftUser */
    public $craftUser;

    /** @var QueryFactory $queryFactory */
    public $queryFactory;

    /** @var UserModel $userModel */
    private $userModel;

    /** @var DBConnection $dbConnection */
    private $dbConnection;

    /**
     * UserService constructor
     * @param User $craftUser
     * @param QueryFactory $queryFactory
     * @param UserModel $userModel
     * @param DBConnection $dbConnection
     * @throws DbException
     * @throws \ReflectionException
     */
    public function __construct(
        User $craftUser,
        QueryFactory $queryFactory,
        UserModel $userModel,
        DBConnection $dbConnection
    ) {
        $this->craftUser = $craftUser;
        $this->queryFactory = $queryFactory;
        $this->dbConnection = $dbConnection;

        if (! $this->craftUser->getId()) {
            $this->userModel = $userModel;
            return;
        }

        $this->userModel = $this->setUserModel($userModel);
    }

    /**
     * Sets the user model
     * @param UserModel $userModel
     * @return UserModel
     * @throws DbException
     * @throws \ReflectionException
     */
    private function setUserModel(UserModel $userModel): UserModel
    {
        $userId = $this->craftUser->getId();

        $query = $this->queryFactory->getQuery()->from('{{%userData}}')
            ->where("`userId` = '{$userId}'")
            ->one();

        if (! $query) {
            $this->dbConnection->createCommand()
                ->insert(
                    '{{%userData}}',
                    [
                        'userId' => $userId,
                    ]
                )
                ->execute();

            $query = $this->queryFactory->getQuery()->from('{{%userData}}')
                ->where("`userId` = '{$userId}'")
                ->one();
        }

        $userModel->setProperties($query);

        $userModel->setProperty(
            'emailAddress',
            $this->craftUser->getIdentity()->email
        );

        return $userModel;
    }

    /**
     * Gets the user model
     * @return UserModel
     */
    public function getUserModel(): UserModel
    {
        return clone $this->userModel;
    }

    /**
     * Populates the ser model from the cart model
     * @param UserModel $userModel
     * @param CartModel $cartModel
     * @return UserModel $userModel
     * @throws \ReflectionException
     */
    public function populateUserModelFromCartModel(
        UserModel $userModel,
        CartModel $cartModel
    ): UserModel {
        $userModel->setProperty('billingCountry', $cartModel->country);
        $userModel->setProperty('billingName', $cartModel->name);
        $userModel->setProperty('billingCompany', $cartModel->company);
        $userModel->setProperty('billingAddress', $cartModel->address);
        $userModel->setProperty('billingAddressContinued', $cartModel->addressContinued);
        $userModel->setProperty('billingCity', $cartModel->city);
        $userModel->setProperty('billingStateProvince', $cartModel->stateProvince);
        $userModel->setProperty('billingPostalCode', $cartModel->postalCode);
        return $userModel;
    }

    /**
     * Saves the user
     * @param UserModel $userModel
     * @throws DbException
     * @throws \ReflectionException
     */
    public function saveUser(UserModel $userModel)
    {
        $this->dbConnection->createCommand()->upsert(
            '{{%userData}}',
            $userModel->getSaveData()
        )
        ->execute();
    }

    /**
     * Adds a card to a user
     * @param CardModel $cardModel
     * @throws DbException
     */
    public function saveUserCard(CardModel $cardModel)
    {
        $this->dbConnection->createCommand()->upsert(
            '{{%storeCards}}',
            $cardModel->getSaveData()
        )
        ->execute();
    }
}
