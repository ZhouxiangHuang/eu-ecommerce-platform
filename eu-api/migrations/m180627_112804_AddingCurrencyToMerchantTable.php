<?php

use yii\db\Migration;

/**
 * Class m180627_112804_AddingCurrencyToMerchantTable
 */
class m180627_112804_AddingCurrencyToMerchantTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%merchants}}', 'currency_id', $this->integer(10)->notNull()->comment('货币单位  ')->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%merchants}}', 'currency_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180627_112804_AddingCurrencyToMerchantTable cannot be reverted.\n";

        return false;
    }
    */
}
