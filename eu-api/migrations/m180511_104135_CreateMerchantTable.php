<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180511_104134_CreateMerchantTable
 */
class m180511_104135_CreateMerchantTable extends Migration
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

        $this->createTable('{{%merchants}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(10)->notNull()->comment('用户'),
            'store_name' => $this->string(20)->notNull()->comment('商户名'),
            'open_at' => $this->string(10)->comment('开店时间'),
            'closed_at' => $this->string(10)->comment('关店时间'),
            'country' => $this->string(11)->comment('国家'),
            'city' => $this->string(11)->comment('城市'),
            'address' => $this->string(50)->comment('地址'),
            'mobile' => $this->string(20)->comment('联系电话'),
            'announcement' => $this->string(50)->comment('公告'),
            'profile_img_name' => $this->string(200)->comment('OSS图片名'),
            'status' => $this->string(3)->comment('状态'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%merchants}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180511_104134_CreateMerchantTable cannot be reverted.\n";

        return false;
    }
    */
}
