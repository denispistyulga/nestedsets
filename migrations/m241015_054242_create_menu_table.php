<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m241015_054242_create_menu_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->createTable('{{%menu}}', [
//            'id' => $this->primaryKey(),
//        ]);

//        id, parent_id, name, left, right, depth, created_at, updated_at

        $this->createTable('{{%menu}}', [
            'id' => $this->primaryKey(),
            //'tree' => $this->integer()->notNull(),
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
        $this->dropTable('{{%menu}}');
    }
}
