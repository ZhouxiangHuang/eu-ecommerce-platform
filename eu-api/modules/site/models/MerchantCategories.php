<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchant_categories".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $name
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class MerchantCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'name', 'status'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'merchant_id' => 'Merchant ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
