<?php

use yii\db\Migration;

/**
 * Class m201018_120935_insert_admin_user_data
 */
class m210126_053445_insert_admin_user_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%admin_users}}',[
            'name'=>'Super Admin',
            'mobile'=>'9876543210',
            'password_hash'=>'$2y$13$9qmCsSOxiOr8EoGNhY6kfeW6KwrcsB8l0H17oCcoet9Q6AAe4NLLW',
            'auth_key'=>'',
            'email'=>'admin@yopmail.com', 
            'status'=>'Active',
            'created_at'=>'12345678',
            'updated_at'=>'12345678',
            'role_id'=>'1',

        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201018_120935_insert_admin_user_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201018_120935_insert_admin_user_data cannot be reverted.\n";

        return false;
    }
    */
}
