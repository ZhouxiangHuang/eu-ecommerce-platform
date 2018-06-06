<?php

use yii\db\Migration;

/**
 * Class m180602_073728_EditProductImageTable
 */
class m180602_073728_EditProductImageTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_images}}', 'status', $this->integer(1)->notNull()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_images}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180602_073728_EditProductImageTable cannot be reverted.\n";

        return false;
    }
    */
}
