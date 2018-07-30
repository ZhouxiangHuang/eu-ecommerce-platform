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

        try{
            $product = new Products();
            $product->merchant_category_id = ArrayHelper::getValue($form, 'merchant_category_id');
            $product->name = ArrayHelper::getValue($form, 'name');
            $product->merchant_id = ArrayHelper::getValue($form, 'merchant_id');
            $product->product_unique_code = ArrayHelper::getValue($form, 'code');
            $product->price = ArrayHelper::getValue($form, 'price');
            $product->encoded = ArrayHelper::getValue($form, 'encoded');
            $product->hot_item = ArrayHelper::getValue($form, 'hot');
            $product->description = ArrayHelper::getValue($form, 'description');
            $product->status = 1;
            $product->save();
            if($product->errors) {
                Yii::error($product->errors);
                return true;
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

    public function updateProduct($form) {
        $id = $form['product_id'];
        $deletes = json_decode($form['delete_list']);
        $product = Products::findOne(['id' => $id]);

        if(!$product) {
            return false;
        }

        $product->merchant_category_id = ArrayHelper::getValue($form, 'merchant_category_id');
        $product->name = ArrayHelper::getValue($form, 'name');
        $product->merchant_id = ArrayHelper::getValue($form, 'merchant_id');
        $product->product_unique_code = ArrayHelper::getValue($form, 'code');
        $product->price = ArrayHelper::getValue($form, 'price');
        $product->encoded = ArrayHelper::getValue($form, 'encoded');
        $product->hot_item = ArrayHelper::getValue($form, 'hot');
        $product->description = ArrayHelper::getValue($form, 'description');
        if($fileName =  ArrayHelper::getValue($form, 'file_name')) {
            $isSuccess = $product->addImage($fileName);
            if(!$isSuccess) {
                return false;
            }
        }
        $product->deleteImage($deletes);
        $product->save();
        if($product->errors) {
            \Yii::error(ArrayHelper::getValue($form, 'price'));
            \Yii::error($product->errors);
            return false;
        } else {
            return true;
        }
    }

    public function getProduct($productId, $showPrice) {
        $product = Products::findOne(['id' => $productId]);
        return Products::format($product, $showPrice);
    }

    public function listProducts($merchantId, $showPrice=false) {
        $categories = MerchantCategories::all($merchantId);
        $products = Products::all($merchantId);
        $productArray = [];

        //添加热卖列表
        $productList = [];
        foreach ($products as $product) {
            if ($product->hot_item) {
                $productList[] = Products::format($product, $showPrice);
            }
        }
        $productArray[] = [
            'id' => 0,
            'name' => '热销',
            'products' => $productList,
            'is_hot' => true
        ];

        //add hot_item category
        /** @var Products $product */

        //TODO: need optimize
        /** @var MerchantCategories $category */
        foreach ($categories as $category) {
            $productList = [];
            /** @var Products $product */
            foreach ($products as $product) {
                if($category->id == $product->merchant_category_id)
                {
                    array_unshift($productList, Products::format($product, $showPrice));
                }
            }
            $productArray[] = [
                'id' => $category->id,
                'name' => $category->name,
                'products' => $productList,
                'is_hot' => false
            ];

        }

        return $productArray;
    }

}