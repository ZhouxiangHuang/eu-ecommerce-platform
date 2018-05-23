<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $id
 * @property string $country_code
 * @property string $name
 * @property string $city_code
 */
class Cities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_code', 'name', 'city_code'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'country_code' => 'Country Code',
            'name' => 'Name',
            'city_code' => 'City Code',
        ];
    }

    static function findByCode($code) {
        return Cities::findOne(['city_code' => $code]);
    }
}
