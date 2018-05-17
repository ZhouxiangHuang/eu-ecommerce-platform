<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180516_131955_CreateMerchantCategories
 */
class m180516_131955_CreateMerchantCategories extends Migration
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

        $this->createTable('{{%merchant_categories}}', [
            'id' => $this->primaryKey(),
            'merchant_id' => $this->integer(10)->comment('产品id'),
            'name' => $this->integer(10)->notNull()->comment('名称'),
            'status' => $this->integer(2)->notNull()->defaultValue(1)->comment('是否显示'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);

        $this->createIndex('merchant', '{{%merchant_categories}}', ['merchant_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%merchant_categories}}');
        $this->dropIndex('merchant', '{{%merchant_categories}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180516_131955_CreateMerchantCategories cannot be reverted.\n";

        return false;
    }
    */
}
