<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchant_qr".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property string $profile_name
 * @property string $created_at
 * @property string $updated_at
 */
class MerchantQr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_qr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id'], 'integer'],
            [['profile_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['profile_name'], 'string', 'max' => 30],
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
            'profile_name' => 'Profile Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
