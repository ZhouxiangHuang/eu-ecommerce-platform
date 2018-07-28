<?php

use yii\db\Migration;

/**
 * Class m180727_044214_EditProductTable
 */
class m180727_044214_EditProductTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'encoded', $this->boolean()->defaultValue(0)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%products}}', 'encoded');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180727_044214_EditProductTable cannot be reverted.\n";

        return false;
    }
    */
}
