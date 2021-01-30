<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%admin_users}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%role}}`
 */
class m210126_053442_add_role_id_column_to_admin_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%admin_users}}', 'role_id', $this->integer());

        // creates index for column `role_id`
        $this->createIndex(
            '{{%idx-admin_users-role_id}}',
            '{{%admin_users}}',
            'role_id'
        );

        // add foreign key for table `{{%role}}`
        $this->addForeignKey(
            '{{%fk-admin_users-role_id}}',
            '{{%admin_users}}',
            'role_id',
            '{{%admin_roles}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%role}}`
        $this->dropForeignKey(
            '{{%fk-admin_users-role_id}}',
            '{{%admin_users}}'
        );

        // drops index for column `role_id`
        $this->dropIndex(
            '{{%idx-admin_users-role_id}}',
            '{{%admin_users}}'
        );

        $this->dropColumn('{{%admin_users}}', 'role_id');
    }
}
