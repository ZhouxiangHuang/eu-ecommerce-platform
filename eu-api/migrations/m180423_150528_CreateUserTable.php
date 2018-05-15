<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180423_150526_CreateUserTable
 */
class m180423_150528_CreateUserTable extends Migration
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

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'wx_union_id' => $this->string(30)->comment('unionId'),
            'wx_open_id' => $this->string(30)->notNull()->comment('openId'),
            'role' => $this->integer(1)->notNull()->comment('角色'),
            'mobile' => $this->string(18)->comment('手机号'),
            'country' => $this->string(10)->comment('国家'),
            'wechat_profile' => $this->string(30)->comment('微信头像'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180423_150526_CreateUserTable cannot be reverted.\n";

        return false;
    }
    */
}
