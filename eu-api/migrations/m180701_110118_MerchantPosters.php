<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180701_110115_MerchantPosters
 */
class m180701_110118_MerchantPosters extends Migration
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

        $this->createTable('{{%posters}}', [
            'id' => $this->primaryKey(),
            'image_url' => $this->string(200)->notNull()->comment('海报链接'),
            'image_scale_x' => $this->float()->comment('海报横向比例'),
            'image_scale_y' => $this->float()->comment('海报纵向比例'),
            'image_pos_x' => $this->integer(5)->comment('海报横向位置'),
            'image_pos_y' => $this->integer(5)->comment('海报总想为止'),
            'qr_pos_x' => $this->integer(5)->comment('二维码横向位置'),
            'qr_pos_y' => $this->integer(5)->comment('二维码总想为止'),
            'qr_scale_x' => $this->float()->comment('二维码横向比例'),
            'qr_scale_y' => $this->float()->comment('二维码纵向比例'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posters}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180701_110115_MerchantPosters cannot be reverted.\n";

        return false;
    }
    */
}
