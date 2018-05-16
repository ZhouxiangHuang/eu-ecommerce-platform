<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/16
 * Time: 上午12:14
 */

namespace app\modules\site;

use app\modules\site\models\Products;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class ProductManager
{
    public function createProduct($form) {
        $uniqueCode = ArrayHelper::getValue($form, 'code');
        $product = Products::getByUniqueCode($uniqueCode);

        try{
            if(!$product) {
                $product = new Products();
                $product->type = ArrayHelper::getValue($form, 'type');
                $product->merchant_id = ArrayHelper::getValue($form, 'merchant_id');
                $product->product_unique_code = $uniqueCode;
                $product->price = ArrayHelper::getValue($form, 'price');
                $product->hot_item = ArrayHelper::getValue($form, 'hot');
                $product->description = ArrayHelper::getValue($form, 'description');
                $product->status = 1;
                $product->save();
            }

            if($fileName =  ArrayHelper::getValue($form, 'file_name')) {
                $product->addImage($fileName);
            }

            return true;
        } catch (Exception $e) {
            \Yii::error($e->getMessage());
            return false;
        }
    }

    public function getProduct($productId) {
        $product = Products::findOne(['id' => $productId]);
        $product->img_urls = $product->getImages();
        return $product;
    }

    public function listProducts($merchantId) {
        $products = Products::all($merchantId);

        /** @var Products $product */
        foreach ($products as $product) {
            $urls = $product->getImages();
            $product->img_urls = $urls;
        }

        return $products;
    }
}