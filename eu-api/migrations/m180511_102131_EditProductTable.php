<?php

use yii\db\Migration;

/**
 * Class m180511_102131_EditProductTable
 */
class m180511_102131_EditProductTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product_categories}}', 'status', $this->integer(1)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product_categories}}', 'status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180511_102131_EditProductTable cannot be reverted.\n";

        return false;
    }
    */
}
