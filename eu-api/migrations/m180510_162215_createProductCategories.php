<?php

use yii\db\Migration;

/**
 * Class m180510_162215_createProductCategories
 */
class m180510_162215_createProductCategories extends Migration
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

        $this->createTable('{{%product_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(10)->notNull()->comment('种类名'),
            'type' => $this->integer(3)->notNull(),
            'parent_id' => $this->integer(3)->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_categories}}');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180510_162215_createProductCategories cannot be reverted.\n";

        return false;
    }
    */
}
