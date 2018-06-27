<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "currencies".
 *
 * @property integer $id
 * @property string $abbreviation
 * @property string $symbol
 * @property integer $rate
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'currencies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['symbol'], 'required'],
            [['rate'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['abbreviation', 'symbol'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'abbreviation' => 'Abbreviation',
            'symbol' => 'Symbol',
            'rate' => 'Rate',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
