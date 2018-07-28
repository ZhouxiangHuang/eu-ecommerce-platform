<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "verification_codes".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $code
 * @property integer $status
 * @property string $type
 * @property string $created_at
 * @property string $updated_at
 */
class VerificationCodes extends \yii\db\ActiveRecord
{
    CONST TYPE_ENCODE_PRICE = "ENCODE_PRC";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'verification_codes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'code'], 'required'],
            [['user_id', 'code', 'status'], 'integer'],
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
            'user_id' => 'User ID',
            'code' => 'Code',
            'status' => 'Status',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function isValid($userId, $code) {
        $timestamp = time() - (15 * 60);
        $fifteenMinutesAgo = date("Y-m-d H:i:s", $timestamp);

        $exist = VerificationCodes::find()
            ->where(['user_id' => $userId, 'code' => $code])
            ->andWhere(['code' => $code])
            ->andWhere("created_at > '" . $fifteenMinutesAgo . "'")
            ->exists();

        return $exist;
    }

    static function generate($userId) {
        $codeModel = new VerificationCodes();
        $codeModel->user_id = $userId;
        $codeModel->code = rand(100000, 999999);
        $codeModel->type = self::TYPE_ENCODE_PRICE;
        $codeModel->status = 1;
        $codeModel->save();
    }
}
