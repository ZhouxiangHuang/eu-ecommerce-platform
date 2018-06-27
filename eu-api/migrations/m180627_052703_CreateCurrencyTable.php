<?php

use yii\db\Migration;
use yii\db\mysql\Schema;

/**
 * Class m180627_052702_CreateCurrencyTable
 */
class m180627_052703_CreateCurrencyTable extends Migration
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

        $this->createTable('{{%currencies}}', [
            'id' => $this->primaryKey(),
            'abbreviation' => $this->string(10)->comment('汇率缩写'),
            'symbol' => $this->string(10)->notNull()->comment('符号'),
            'rate' => $this->integer(10)->notNull()->defaultValue(1)->comment('汇率（以欧元为准）'),
            'status' => $this->integer(5)->notNull()->defaultValue(1)->comment('状态'),
            'created_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP COMMENT "创建时间"',
            'updated_at' => Schema::TYPE_TIMESTAMP . ' DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT "更新时间"',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%currencies}}');
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_052702_CreateCurrencyTable cannot be reverted.\n";

        return false;
    }
    */
}
