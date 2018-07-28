<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchant_authorization".
 *
 * @property integer $id
 * @property integer $merchant_id
 * @property integer $user_id
 * @property integer $is_valid
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 */
class MerchantAuthorization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchant_authorization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['merchant_id', 'user_id'], 'required'],
            [['merchant_id', 'user_id', 'is_valid'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 10],
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
            'user_id' => 'User ID',
            'is_valid' => 'Is Valid',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function isAuthorized($merchantId, $userId, $type) {
        $result = MerchantAuthorization::find()
            ->where(['merchant_id' => $merchantId, 'user_id' => $userId, 'is_valid' => 1, 'type' => $type])
            ->exists();

        return $result;
    }

    static function authorize($merchantId, $userId, $type) {
        $model = new MerchantAuthorization();
        $model->merchant_id = $merchantId;
        $model->user_id = $userId;
        $model->type = $type;
        $model->save();
    }
}
