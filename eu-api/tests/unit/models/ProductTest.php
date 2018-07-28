<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/27
 * Time: 下午12:34
 */

namespace tests\models;


use app\modules\site\models\Products;

class ProductTest extends \Codeception\Test\Unit
{
    private $productId = 2;

    public function testProductPriceEncode() {
        $product = Products::findOne(['id' => $this->productId]);
        $product->encodePrice();
        $price = $product->getPrice();
        expect($price)->equals('****');
        $product = Products::findOne(['id' => $this->productId]);
        $price = $product->getPrice();
        expect($price)->equals('****');
    }

    public function testProductPriceDecode() {
        $product = Products::findOne(['id' => $this->productId]);
        $product->decodePrice();
        $price = $product->getPrice();
        expect($price)->notEquals('****');
        $product = Products::findOne(['id' => $this->productId]);
        $price = $product->getPrice();
        expect($price)->notEquals('****');
    }
}