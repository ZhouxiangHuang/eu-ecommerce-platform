<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $id
 * @property string $name
 * @property string $tel_code
 * @property string $country_code
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'tel_code', 'country_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'tel_code' => 'Tel Code',
            'country_code' => 'Country Code',
        ];
    }

    static function findByCode($code) {
        return Countries::findOne(['country_code' => $code]);
    }

    static function getTelCodes() {
        return Countries::find()->where(['>', 'id', 0])->select(['name', 'tel_code'])->all();
    }
}
