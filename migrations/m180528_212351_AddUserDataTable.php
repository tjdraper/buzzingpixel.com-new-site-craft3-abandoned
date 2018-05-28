<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180528_212351_AddUserDataTable migration.
 */
class m180528_212351_AddUserDataTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        if ($this->getDb()->tableExists('{{%userData}}')) {
            return true;
        }

        $this->createTable('{{%userData}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer(11),
            'stripeCustomerId' => $this->string(),
            'displayName' => $this->string(),
            'billingPhoneNumber' => $this->string(),
            'billingCountry' => $this->string(),
            'billingName' => $this->string(),
            'billingCompany' => $this->string(),
            'billingAddress' => $this->string(),
            'billingAddressContinued' => $this->string(),
            'billingCity' => $this->string(),
            'billingStateProvince' => $this->string(),
            'billingPostalCode' => $this->string(),
            'dateCreated' => $this->dateTime()->notNull(),
            'dateUpdated' => $this->dateTime()->notNull(),
            'uid' => $this->uid(),
        ]);

        $this->addForeignKey(
            null,
            '{{%userData}}',
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
        $this->dropTableIfExists('{{%userData}}');

        return true;
    }
}
