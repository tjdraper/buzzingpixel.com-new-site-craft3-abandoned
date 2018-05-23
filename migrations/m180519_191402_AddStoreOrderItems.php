<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180519_191402_AddStoreOrderItems migration.
 */
class m180519_191402_AddStoreOrderItems extends Migration
{
    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function safeUp(): bool
    {
        if ($this->getDb()->tableExists('{{%storeOrderItems}}')) {
            return true;
        }

        $this->createTable('{{%storeOrderItems}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'orderId' => $this->integer(11),
            'key' => $this->string(255),
            'title' => $this->string(255),
            'version' => $this->string(255),
            'price' => $this->string(255),
            'originalPrice' => $this->string(255),
            'isUpgrade' => $this->boolean(),
            'hasBeenUpgraded' => $this->boolean(),
            'requiresSubscription' => $this->boolean(),
            'isSubscribed' => $this->boolean(),
            'licenseKey' => $this->string(255),
            'notes' => $this->string(255),
            'authorizedDomains' => $this->json(),
            'disabled' => $this->boolean(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);

        $this->addForeignKey(
            null,
            '{{%storeOrderItems}}',
            'userId',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            null,
            '{{%storeOrderItems}}',
            'orderId',
            '{{%storeOrders}}',
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
        $this->dropTableIfExists('{{%storeOrderItems}}');

        return true;
    }
}
