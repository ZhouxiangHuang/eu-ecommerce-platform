<?php

use yii\db\Migration;

/**
 * Class m180722_073645_EditMerchantTable
 */
class m180722_073645_EditMerchantTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%merchants}}', 'score', $this->integer(10)->defaultValue(0)->comment('score'));
        $this->createIndex('score', '{{%merchants}}', ['score']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->$this->dropColumn('{{%merchants}}', 'score');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180722_073645_EditMerchantTable cannot be reverted.\n";

        return false;
    }
    */
}
