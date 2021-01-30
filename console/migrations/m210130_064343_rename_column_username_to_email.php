<?php

use yii\db\Migration;

/**
 * Class m210130_064343_rename_column_username_to_email
 */
class m210130_064343_rename_column_username_to_email extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('admin_users','username','email');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210130_064343_rename_column_username_to_email cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210130_064343_rename_column_username_to_email cannot be reverted.\n";

        return false;
    }
    */
}
