<?php

use yii\db\Migration;

/**
 * Class m180722_132007_EditProducts
 */
class m180722_132007_EditProducts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%products}}', 'price', $this->string(10)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%products}}', 'price', $this->integer(10)->notNull()->comment('价格'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180722_132007_EditProducts cannot be reverted.\n";

        return false;
    }
    */
}
