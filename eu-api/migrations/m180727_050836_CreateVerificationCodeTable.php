<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180727_050836_CreateVerificationCodeTable
 */
class m180727_050836_CreateVerificationCodeTable extends Migration
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

        $this->createTable('{{%verification_codes}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(9)->notNull()->comment('用户'),
            'code' => $this->integer(6)->notNull()->comment('密码'),
            'status' => $this->integer(5)->comment('状态'),
            'type' => $this->string(10)->comment('类型'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
        $this->createIndex('code', '{{%verification_codes}}', ['code', 'status', 'created_at']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180727_050836_CreateVerificationCodeTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180727_050836_CreateVerificationCodeTable cannot be reverted.\n";

        return false;
    }
    */
}
