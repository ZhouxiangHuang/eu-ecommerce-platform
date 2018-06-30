<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180630_075226_MerchantQrCode
 */
class m180630_075226_MerchantQrCode extends Migration
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

        $this->createTable('{{%merchant_qr}}', [
            'id' => $this->primaryKey(),
            'merchant_id' => $this->integer(30)->comment('商户id'),
            'profile_name' => $this->string(200)->notNull()->comment('oss文件名'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180630_075226_MerchantQrCode cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180630_075226_MerchantQrCode cannot be reverted.\n";

        return false;
    }
    */
}
