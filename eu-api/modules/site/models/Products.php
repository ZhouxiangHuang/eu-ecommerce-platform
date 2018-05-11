<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $type 产品种类
 * @property int $price 价格
 * @property int $merchant_id 商户
 * @property string $product_unique_code 编号
 * @property int $cover_image 封面图
 * @property int $hot_item 是否热销
 * @property int $status 状态
 * @property string $description 简介
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'price', 'merchant_id', 'product_unique_code'], 'required'],
            [['price', 'merchant_id', 'cover_image'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 18],
            [['product_unique_code'], 'string', 'max' => 10],
            [['hot_item'], 'string', 'max' => 1],
            [['description'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'price' => 'Price',
            'merchant_id' => 'Merchant ID',
            'product_unique_code' => 'Product Unique Code',
            'cover_image' => 'Cover Image',
            'hot_item' => 'Hot Item',
            'description' => 'Description',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
