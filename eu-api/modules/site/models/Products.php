<?php

namespace app\modules\site\models;

use app\common\DataSource;
use app\helpers\Oss;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $type 产品种类
 * @property string $name 产品名称
 * @property int $price 价格
 * @property int $merchant_id 商户
 * @property string $product_unique_code 编号
 * @property int $cover_image 封面图
 * @property int $hot_item 是否热销
 * @property int $status 状态
 * @property int $merchant_category_id 种类id
 * @property string $description 简介
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Products extends \yii\db\ActiveRecord
{
    public $img_urls;

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
            [['price', 'merchant_id', 'product_unique_code'], 'required'],
            [['price', 'merchant_id', 'cover_image', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type'], 'string', 'max' => 18],
            [['product_unique_code'], 'string', 'max' => 10],
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

    static function detail($id) {
        return Products::findOne(['id' => $id]);
    }

    static function all($merchantId) {
        return Products::findAll(['merchant_id' => $merchantId]);
    }

    static function getByUniqueCode($code) {
        $product = Products::findOne(['product_unique_code' => $code]);
        return $product;
    }

    public function addImage($fileName) {
        if(!isset($_FILES[$fileName])) {
            return null;
        }
        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $dateTime = time() . rand(111, 999);
        $name = 'wx_' . $dateTime . '.' . $ext;

        $uploadedFile = UploadedFile::getInstanceByName($fileName);
        $uploadedFile->saveAs($path = '/tmp/' . $name);

        $oss = new Oss();
        $isSuccess = $oss->putObject($name, $path);

        if($isSuccess) {
            unlink($path);
            ProductImages::create($this->id, $name, 3600);
        }
    }

    public function deleteImage($uniqueNames) {
        foreach ($uniqueNames as $name) {
            $isSuccess = ProductImages::deleteImage($name);
            if(!$isSuccess) {
                return false;
            }
        }
        return true;
    }

    public function getImages() {
        $urls = ProductImages::getImages($this->id);
        return $urls;
    }

    static function format(Products $product) {
        $product = [
            'id' => $product->id,
            'price' => $product->price,
            'name' => $product->name,
            'product_unique_code' => $product->product_unique_code,
            'hot_item' => $product->hot_item,
            'description' => $product->description,
            'merchant_category_id' => $product->merchant_category_id,
            'images' => $product->getImages()
        ];

        return $product;
    }
}
