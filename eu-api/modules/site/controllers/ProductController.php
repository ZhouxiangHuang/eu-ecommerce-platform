<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:45
 */

namespace app\modules\site\controllers;

use app\modules\site\models\MerchantCategories;
use app\modules\site\models\ProductCategories;
use app\modules\site\models\Products;
use app\modules\site\models\User;
use app\modules\site\models\UserCollections;
use app\modules\site\ProductFactory;
use app\modules\site\ProductManager;
use Yii;

class ProductController extends BaseController
{

    public function actionCreate() {
        $form = [
            'file_name' => Yii::$app->request->post('file_name'),
            'type' => Yii::$app->request->post('type'),
            'category_id' => Yii::$app->request->post('category_id'),
            'price' => Yii::$app->request->post('price'),
            'code' => Yii::$app->request->post('code'),
            'hot' =>  Yii::$app->request->post('hot'),
            'description' => Yii::$app->request->post('description'),
            'merchant_id' => 1
        ];

        $productManager = new ProductManager();
        $isSuccess = $productManager->createProduct($form);

        return $this->returnJson([], $isSuccess);
    }

    public function actionDetail($product_id) {
        $productManager = new ProductManager();
        $product = $productManager->getProduct($product_id);
        return $this->returnJson($product, true);
    }

    public function actionProducts() {
//        $merchant = $this->getMerchantModel();
//        $merchant_id = $merchant->id;

        $merchant_id = 1;
        $productManager = new ProductManager();
        $products = $productManager->listProducts($merchant_id);

        return $this->returnJson($products, true);
    }

    public function collect() {
        $productId = Yii::$app->request->post('product_id');
        $user = $this->getUserModel();
        $isSuccess = UserCollections::add($user->id, $productId);
        return $this->returnJson([], $isSuccess);
    }

    public function discard() {
        $productId = Yii::$app->request->post('product_id');
        $user = $this->getUserModel();
        $isSuccess = UserCollections::discard($user->id, $productId);
        return $this->returnJson([], $isSuccess);
    }

    public function actionCategories() {
        $categories = ProductCategories::getAll();
        return json_encode($categories);
    }

    public function actionAddMerchantCategory() {
        $name = Yii::$app->request->post('name');
//        $merchant = $this->getMerchantModel();
        $model = new MerchantCategories();
//        $model->merchant_id = $merchant->id;
        $model->merchant_id = 1;
        $model->name = $name;
        $model->save();
        if($model->errors) {
            Yii::error($model->errors);
        }
        return $this->returnJson([], $model->save());
    }

}