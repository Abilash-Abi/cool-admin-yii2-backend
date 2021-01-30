<?php

use yii\db\Migration;

/**
 * Class m210128_184316_alter_status_column_from_admin_users
 */
class m210128_184316_alter_status_column_from_admin_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('admin_users','status',$this->string(10));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210128_184316_alter_status_column_from_admin_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210128_184316_alter_status_column_from_admin_users cannot be reverted.\n";

        return false;
    }
    */
}
