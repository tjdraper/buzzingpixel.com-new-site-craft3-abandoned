<?php

namespace craft\contentmigrations;

use Craft;
use craft\db\Migration;

/**
 * m180501_011127_AddBillingAddressColumnsToStoreCartTable migration.
 */
class m180501_011127_AddBillingAddressColumnsToStoreCartTable extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%storeCart}}',
            'phoneNumber',
            $this->string(255)->after('cartData')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'country',
            $this->string(255)->after('phoneNumber')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'name',
            $this->string(255)->after('country')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'company',
            $this->string(255)->after('name')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'address',
            $this->string(255)->after('company')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'addressContinued',
            $this->string(255)->after('address')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'city',
            $this->string(255)->after('addressContinued')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'stateProvince',
            $this->string(255)->after('city')
        );

        $this->addColumn(
            '{{%storeCart}}',
            'postalCode',
            $this->string(255)->after('stateProvince')
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown(): bool
    {
        $this->dropColumn('{{%storeCart}}', 'phoneNumber');

        $this->dropColumn('{{%storeCart}}', 'country');

        $this->dropColumn('{{%storeCart}}', 'name');

        $this->dropColumn('{{%storeCart}}', 'company');

        $this->dropColumn('{{%storeCart}}', 'address');

        $this->dropColumn('{{%storeCart}}', 'addressContinued');

        $this->dropColumn('{{%storeCart}}', 'city');

        $this->dropColumn('{{%storeCart}}', 'stateProvince');

        $this->dropColumn('{{%storeCart}}', 'postalCode');

        return true;
    }
}
