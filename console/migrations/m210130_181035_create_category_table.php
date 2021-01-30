<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m210130_181035_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20),
            'status' => $this->string(20)->defaultValue('Active'),
            'created_on' => $this->dateTime(),
            'created_by' => $this->integer(),
            'created_ip' => $this->string(50),
            'modified_on' => $this->dateTime(),
            'modified_by' => $this->integer(),
            'modified_ip' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
