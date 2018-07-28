<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180728_051206_MerchantAuthorization
 */
class m180728_051206_MerchantAuthorization extends Migration
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

        $this->createTable('{{%merchant_authorization}}', [
            'id' => $this->primaryKey(),
            'merchant_id' => $this->integer(9)->notNull()->comment('授权商户'),
            'user_id' => $this->integer(9)->notNull()->comment('被授权用户'),
            'is_valid' => $this->boolean()->notNull()->defaultValue(1)->comment('是否有效'),
            'type' => $this->string(10)->comment('授权类型'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
        $this->createIndex('auth', '{{%merchant_authorization}}', ['merchant_id', 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180728_051206_MerchantAuthorization cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180728_051206_MerchantAuthorization cannot be reverted.\n";

        return false;
    }
    */
}
