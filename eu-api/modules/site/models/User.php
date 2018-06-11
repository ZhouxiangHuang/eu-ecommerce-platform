<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $last_login_role
 * @property string $wx_union_id
 * @property string $wx_open_id
 * @property string $mobile
 * @property string $country
 * @property string $wechat_profile
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    const ROLE_MERCHANT = 1;
    const ROLE_COSTUMER = 2;

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
            [['wx_open_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['wx_union_id', 'wx_open_id', 'wechat_profile'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 18],
            [['country'], 'string', 'max' => 10],
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
            'mobile' => 'Mobile',
            'country' => 'Country',
            'wechat_profile' => 'Wechat Profile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function getId($openId) {
        $user = User::findOne(['wx_open_id' => $openId]);
        if(!$user) {
            return false;
        } else {
            return $user->id;
        }
    }

    static function getMerchant($userId) {
        return Merchants::findOne(['user_id' => $userId]);
    }

    static function updateLastLoginRole($userId, $role) {
        $user = User::findOne(['id' => $userId]);
        $user->last_login_role = $role;
        return $user->save();
    }

    static function register($openId) {
        $user = new User();
        $user->wx_open_id = $openId;
        $user->last_login_role = User::ROLE_COSTUMER;
        return $user->save();
    }
}
