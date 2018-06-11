<?php

namespace craft\contentmigrations;

use craft\db\Migration;

/**
 * m180611_220314_AddPaymentMethodToCartTable migration.
 */
class m180611_220314_AddPaymentMethodToCartTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp(): bool
    {
        $this->addColumn(
            '{{%storeCart}}',
            'paymentMethod',
            $this->string()->after('cartData')
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropColumn('{{%storeCart}}', 'paymentMethod');

        return true;
    }
}
