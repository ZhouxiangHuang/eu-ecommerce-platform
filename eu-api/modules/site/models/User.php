<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $wx_union_id unionId
 * @property string $wx_open_id openId
 * @property int $role 角色
 * @property string $mobile 手机号
 * @property string $country 国家
 * @property string $wechat_profile 微信头像
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class User extends \yii\db\ActiveRecord
{
    const ROLE_MERCHANT = 1;
    const ROLE_CUSTOMER = 2;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wx_open_id', 'role'], 'required'],
            [['role'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['wx_union_id', 'wx_open_id'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 18],
            [['country'], 'string', 'max' => 10],
            [['wechat_profile'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wx_union_id' => 'Wx Union ID',
            'wx_open_id' => 'Wx Open ID',
            'role' => 'Role',
            'mobile' => 'Mobile',
            'country' => 'Country',
            'wechat_profile' => 'Wechat Profile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function getId($openId, $role) {
        $user = User::findOne(['wx_open_id' => $openId, 'role' => $role]);
        return $user ? $user->id : false;
    }

    static function register($openId, $role) {
        $user = new User();

        Yii::error($openId);


        $user->wx_open_id = $openId;
        $user->role = $role;
        $user->save();

        if($user->errors) {
            Yii::error($user->errors);
            return false;
        } else {
            return true;
        }
    }

    static function isValid($mobile) {
        $user = User::findOne(['mobile' => $mobile]);
        return $user ? true : false;
    }

    static function getMerchant($userId) {
        return Merchants::findOne(['user_id' => $userId]);
    }
}
