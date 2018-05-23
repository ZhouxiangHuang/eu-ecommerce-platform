<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchants".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property string $store_name 商户名
 * @property string $open_at 开店时间
 * @property string $closed_at 关店时间
 * @property string $country 国家
 * @property string $city 城市
 * @property string $address 地址
 * @property string $mobile 联系电话
 * @property string $announcement 公告
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Merchants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_name'], 'required'],
            [['open_at', 'closed_at', 'created_at', 'updated_at'], 'safe'],
            [['store_name'], 'string', 'max' => 20],
            [['address', 'announcement'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_name' => 'Store Name',
            'open_at' => 'Open At',
            'closed_at' => 'Closed At',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'announcement' => 'Announcement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function register($userId, $storeName, $address, $mobile) {
        $merchant = new Merchants();
        $merchant->user_id = $userId;
        $merchant->store_name = $storeName;
        $merchant->address = $address;
        $merchant->mobile = $mobile;
        $merchant->save();
        if($merchant->errors) {
            Yii::error($merchant->errors);
            return false;
        }
        return true;
    }
}
