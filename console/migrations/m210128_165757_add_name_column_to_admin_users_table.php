<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%admin_users}}`.
 */
class m210128_165757_add_name_column_to_admin_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('admin_users','name',$this->string(20)->after('id'));
        $this->addColumn('admin_users','mobile',$this->string(15)->after('name'));
        $this->dropColumn('admin_users','email');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
