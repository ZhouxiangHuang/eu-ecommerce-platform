<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:45
 */

namespace app\modules\site\controllers;


use app\modules\site\ProductFactory;
use Yii;

class ProductController extends BaseController
{
    public function actionCreate() {

        $form = [
            'type' => Yii::$app->request->post('type'),
            'price' => Yii::$app->request->post('price'),
            'code' => Yii::$app->request->post('code'),
            'hot' =>  Yii::$app->request->post('hot'),
            'description' => Yii::$app->request->post('description')
        ];

        $product = ProductFactory::create($form);
        $product->save();
    }

    public function actionDetail($product_id) {

    }

    public function actionProducts($merchant_id) {

    }

}