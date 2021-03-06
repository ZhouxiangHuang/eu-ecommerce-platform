<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180511_105847_CreateTagsTable
 */
class m180511_105847_CreateTagsTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%tags}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(20)->notNull()->comment('商户名'),
            'category_id' => $this->integer(10)->notNull()->comment('商户名'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tags}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180511_105847_CreateTagsTable cannot be reverted.\n";

        return false;
    }
    */
}
