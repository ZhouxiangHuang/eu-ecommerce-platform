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
        $collected = UserCollections::findOne(['user_id' => $userId, 'product_id' => $productId, 'status' => 0]);

        if(!$collected) {
            $model = new UserCollections();
            $model->product_id = $productId;
            $model->user_id = $userId;
            $model->save();
        } else {
            $collected->status = 1;
            $collected->save();
        }

        return true;
    }

    static function discard($userId, $productId) {
        $collection = UserCollections::findOne(['user_id' => $userId, 'product_id' => $productId, 'status' => 1]);
        $collection->status = 0;
        return $collection->save();
    }

    static function all($userId) {
        //TODO: need optimize
        $collections = UserCollections::findAll(['user_id' => $userId, 'status' => 1]);

        $collectionsArray = [];
        foreach ($collections as $collection) {
            $product = Products::findOne(['id' => $collection->product_id]);
            $merchant = Merchants::findOne(['id' => $product->merchant_id]);
            $productFormatted = Products::format($product);

            $inArray = false;
            for($i = 0; $i < count($collectionsArray); $i++) {
                if($collectionsArray[$i]['merchant_id'] == $merchant->id) {
                    array_push($collectionsArray[$i]['products'], $productFormatted);
                    $inArray = true;
                    break;
                }
            }

            //如果已经存在的商户，在上一个循环已经添加商品，可以直接跳过
            if($inArray) {
                continue;
            } else {
                $set = [];
                $set['merchant_id'] = $merchant->id;
                $set['merchant_name'] = $merchant->store_name;
                $set['currency'] = $merchant->getCurrency();
                $set['products'] = [$productFormatted]; //必须是数组，以便加入其它产品
                $collectionsArray[] = $set;
            }
        }

        return $collectionsArray;
    }

}
