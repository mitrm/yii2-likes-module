<?php

use yii\db\Migration;

/**
 * Handles the creation and droping for table `likes_module` in the database.
 */
class m160608_153547_create_likes_module extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('likes_object', [
            'id' => $this->primaryKey(),
            'table' => $this->string(50),
            'field_id' => $this->integer(),
            'sum_likes' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createTable('likes_object_item', [
            'id' => $this->primaryKey(),
            'likes_object_id' => $this->integer(),
            'user_id' => $this->integer(),
            'num' => $this->smallInteger(), // -1, 0, 1
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->createIndex('likes_object_id', 'likes_object_item', 'likes_object_id');
        $this->createIndex('user_id', 'likes_object_item', 'user_id');
        $this->createIndex('num', 'likes_object_item', 'num');
        $this->createIndex('table', 'likes_object', 'table');
        $this->createIndex('field_id', 'likes_object', 'field_id');
        $this->createIndex('sum_likes', 'likes_object', 'sum_likes');
        $this->createIndex('table_field_id', 'likes_object', ['sum_likes', 'field_id']);

        $this->addForeignKey('FR_likes_object_item', 'likes_object_item', 'likes_object_id', 'likes_object', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('likes_object_item');
        $this->dropTable('likes_object');
    }
}
