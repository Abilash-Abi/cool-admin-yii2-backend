<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%admin_users}}`.
 */
class m210130_072834_add_otp_column_to_admin_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_users}}', 'otp', $this->integer()->after('password_hash'));
        $this->addColumn('{{%admin_users}}', 'reset_otp_expired_on', $this->dateTime()->after('otp'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%admin_users}}', 'otp');
        $this->dropColumn('{{%admin_users}}', 'reset_otp_expired_on');
    }
}
