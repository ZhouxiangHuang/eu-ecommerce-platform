<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:40
 */

namespace app\modules\site;


use app\modules\site\interfaces\ProductFactoryInterface;
use app\modules\site\models\Products;
use yii\helpers\ArrayHelper;

class ProductFactory implements ProductFactoryInterface
{
    static function create($form)
    {
        
        $product = new Products();
        $product->type = ArrayHelper::getValue($form, 'type');
        $product->merchant_id = ArrayHelper::getValue($form, 'merchant_id');
        $product->product_unique_code = ArrayHelper::getValue($form, 'code');
        $product->price = ArrayHelper::getValue($form, 'price');
        $product->hot_item = ArrayHelper::getValue($form, 'hot');
        $product->description = ArrayHelper::getValue($form, 'description');
        $product->status = 1;
        return $product->save();
    }
}