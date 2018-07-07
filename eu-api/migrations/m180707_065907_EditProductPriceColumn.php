<?php

use yii\db\Migration;

/**
 * Class m180707_065907_EditProductPriceColumn
 */
class m180707_065907_EditProductPriceColumn extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%products}}', 'price', $this->integer(10)->comment('价格'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%products}}', 'price', $this->integer(10)->notNull()->comment('价格'));
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180707_065907_EditProductPriceColumn cannot be reverted.\n";

        return false;
    }
    */
}
