<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/16
 * Time: 上午12:14
 */

namespace app\modules\site;

use app\modules\site\models\MerchantCategories;
use app\modules\site\models\Products;
use Yii;
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
                $product->merchant_category_id = ArrayHelper::getValue($form, 'merchant_category_id');
                $product->name = ArrayHelper::getValue($form, 'name');
                $product->merchant_id = ArrayHelper::getValue($form, 'merchant_id');
                $product->product_unique_code = $uniqueCode;
                $product->price = ArrayHelper::getValue($form, 'price');
                $product->hot_item = ArrayHelper::getValue($form, 'hot');
                $product->description = ArrayHelper::getValue($form, 'description');
                $product->status = 1;
                $product->save();
                if($product->errors) {
                    Yii::error($product->errors);
                    return true;
                }
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
        return Products::format($product);
    }

    public function listProducts($merchantId) {
        $categories = MerchantCategories::all($merchantId);
        $products = Products::all($merchantId);

        $productArray = [];
        /** @var MerchantCategories $category */
        foreach ($categories as $category) {
            $tmpArray = [];
            /** @var Products $product */
            foreach ($products as $product) {
                if($category->id == $product->merchant_category_id)
                {
                    $tmpArray[] = Products::format($product);
                }

                $productArray[] = [$category->name => $tmpArray];
            }

            //如果没有产品，渲染类别
            if(empty($products)) {
                $productArray[] = [$category->name => []];
            }
        }

        return $productArray;
    }

}