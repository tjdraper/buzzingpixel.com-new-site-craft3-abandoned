<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180422_001315_CreateStoreCartTable migration.
 */
class m180422_001315_CreateStoreCartTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        if ($this->getDb()->tableExists('{{%storeCart}}')) {
            return true;
        }

        $this->createTable('{{%storeCart}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'sessionId' => $this->string(255),
            'cartData' => $this->text(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);

        $this->addForeignKey(
            null,
            '{{%storeCart}}',
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
        $this->dropTableIfExists('{{%storeCart}}');

        return true;
    }
}
