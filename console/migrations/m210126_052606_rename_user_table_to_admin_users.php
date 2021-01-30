<?php

use yii\db\Migration;

/**
 * Class m210126_052606_rename_user_table_to_admin_users
 */
class m210126_052606_rename_user_table_to_admin_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->renameTable("user","admin_users");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210126_052606_rename_user_table_to_admin_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210126_052606_rename_user_table_to_admin_users cannot be reverted.\n";

        return false;
    }
    */
}
