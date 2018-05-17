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
    public function safeUp()
    {
        $this->addColumn(
            '{{%storeCart}}',
            'updateAccountInfo',
            $this->boolean()->after('postalCode')
        );
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
