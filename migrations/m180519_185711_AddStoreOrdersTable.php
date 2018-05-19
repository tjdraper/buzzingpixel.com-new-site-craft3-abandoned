<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180519_185711_AddStoreOrdersTable migration.
 */
class m180519_185711_AddStoreOrdersTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        if ($this->getDb()->tableExists('{{%storeOrders}}')) {
            return true;
        }

        $this->createTable('{{%storeOrders}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'transactionId' => $this->string(255),
            'transactionAmount' => $this->integer(11),
            'balanceTransactionId' => $this->string(255),
            'transactionCaptured' => $this->boolean(),
            'transactionCreated' => $this->integer(11),
            'transactionCurrency' => $this->string(255),
            'transactionDescription' => $this->text(),
            'subTotal' => $this->string(255),
            'tax' => $this->string(255),
            'total' => $this->string(255),
            'name' => $this->string(255),
            'company' => $this->string(255),
            'phoneNumber' => $this->string(255),
            'country' => $this->string(255),
            'address' => $this->string(255),
            'addressContinued' => $this->string(255),
            'city' => $this->string(255),
            'stateProvince' => $this->string(255),
            'postalCode' => $this->string(255),
        ]);

        $this->addForeignKey(
            null,
            '{{%storeOrders}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropTableIfExists('{{%storeOrders}}');

        return true;
    }
}
