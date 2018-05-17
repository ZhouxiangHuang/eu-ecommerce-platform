<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "user_collections".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class UserCollections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_collections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'status'], 'integer'],
            [['user_id'], 'required'],
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
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function add($userId, $productId){
        $model = new UserCollections();
        $model->product_id = $productId;
        $model->user_id = $userId;
        return $model->save();
    }

    static function discard($userId, $productId) {
        $collection = UserCollections::findOne(['user_id' => $userId, 'product_id' => $productId]);
        $collection->status = 0;
        return $collection->save();
    }
}
