<?php

use yii\db\Migration;

/**
 * Class m180610_065106_EditUserTable
 */
class m180610_065106_EditUserTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%users}}', 'last_login_role', $this->integer(1)->notNull()->comment('上次登录角色'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'last_login_role');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180610_065106_EditUserTable cannot be reverted.\n";

        return false;
    }
    */
}
