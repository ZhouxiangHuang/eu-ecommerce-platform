<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180511_105847_CreateTagsTable
 */
class m180511_120204_CreateMerchantTagsTable extends Migration
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

        $this->createTable('{{%merchants_tags}}', [
            'id' => $this->primaryKey(),
            'tag_id' => $this->integer(11)->notNull()->comment('标签category'),
            'merchant_id' => $this->integer(11)->comment('商户'),
            'status' => $this->integer(2)->defaultValue(1)->comment('状态'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('tag', '{{%merchants_tags}}', ['merchant_id', 'tag_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%merchants_tags}}');
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
