<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchants_tags".
 *
 * @property int $id
 * @property int $status
 * @property string $tag_id 商户名
 * @property string $merchant_id 开店时间
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class MerchantsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchants_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id'], 'required'],
            [['merchant_id', 'created_at', 'updated_at'], 'safe'],
            [['tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'merchant_id' => 'Merchant ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
