<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180517_023424_AddUpdateAcctInfoColToCartTable migration.
 */
class m180517_023424_AddUpdateAcctInfoColToCartTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->addColumn(
            '{{%storeCart}}',
            'updateAccountInfo',
            $this->boolean()->after('postalCode')
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropColumn('{{%storeCart}}', 'phoneNumber');

        return true;
    }
}
