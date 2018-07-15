<?php

use yii\db\Migration;

/**
 * Class m180715_093010_EditPosterTable
 */
class m180715_093011_EditPosterTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%posters}}', 'font_color', $this->string(10)->comment('颜色'));
        $this->addColumn('{{%posters}}', 'font_size', $this->integer(10)->comment('字体大小'));
        $this->addColumn('{{%posters}}', 'font_x', $this->integer(10)->comment('字体x轴位置'));
        $this->addColumn('{{%posters}}', 'font_y', $this->integer(10)->comment('字体y轴位置'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180715_093010_EditPosterTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180715_093010_EditPosterTable cannot be reverted.\n";

        return false;
    }
    */
}
