<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180516_063957_CreateUserCollectionsTable
 */
class m180516_063957_CreateUserCollectionsTable extends Migration
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

        $this->createTable('{{%user_collections}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(10)->comment('产品id'),
            'user_id' => $this->integer(10)->notNull()->comment('用户'),
            'status' => $this->integer(2)->notNull()->defaultValue(1)->comment('正在关注'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('user_product', '{{%user_collections}}', ['user_id', 'product_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_collections}}');
        $this->dropIndex('user_product', '{{%user_collections}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180516_063957_CreateUserCollectionsTable cannot be reverted.\n";

        return false;
    }
    */
}
