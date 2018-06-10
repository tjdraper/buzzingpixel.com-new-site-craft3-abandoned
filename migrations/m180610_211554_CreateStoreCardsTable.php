<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180610_211554_CreateStoreCardsTable migration.
 */
class m180610_211554_CreateStoreCardsTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        if ($this->getDb()->tableExists('{{%storeCards}}')) {
            return true;
        }

        $this->createTable('{{%storeCards}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'stripeCardId' => $this->string(),
            'cardNickName' => $this->string(),
        ]);

        $this->addForeignKey(
            null,
            '{{%storeCards}}',
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
        $this->dropTableIfExists('{{%storeCards}}');

        return true;
    }
}
