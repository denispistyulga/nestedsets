<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%folders}}`.
 */
class m241017_161606_create_folders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%folders}}', [
            'id' => $this->primaryKey(),
            'tree' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'left' => $this->integer()->notNull(),
            'right' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%folders}}');
    }
}
