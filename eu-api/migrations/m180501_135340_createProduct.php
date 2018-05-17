<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180501_135338_createProduct
 */
class m180501_135340_createProduct extends Migration
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

        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(18)->notNull()->comment('产品种类'),
            'price' => $this->integer(10)->notNull()->comment('价格'),
            'merchant_id' => $this->integer(10)->notNull()->comment('商户'),
            'product_unique_code' => $this->string(10)->notNull()->comment('编号'),
            'cover_image' => $this->integer()->comment('封面图'),
            'hot_item' => $this->boolean()->defaultValue(0)->comment('是否热销'),
            'description' => $this->string(200)->comment('简介'),
            'status' => $this->integer(2)->comment('状态'),
            'category_id' => $this->integer(10)->comment('归类'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180501_135338_createProduct cannot be reverted.\n";

        return false;
    }
    */
}
