<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180515_144407_CreateProductImageTable
 */
class m180515_144408_CreateProductImageTable extends Migration
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

        $this->createTable('{{%product_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(10)->comment('产品id'),
            'unique_name' => $this->string(30)->notNull()->comment('照片名称'),
            'url' => $this->string(200)->comment('url'),
            'expired_at' => $this->timestamp()->comment('过期时间'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_images}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180515_144407_CreateProductImageTable cannot be reverted.\n";

        return false;
    }
    */
}
