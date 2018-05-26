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
            'name' => Yii::$app->request->post('name'),
            'merchant_category_id' => Yii::$app->request->post('merchant_category_id'),
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
        $merchant = $this->getMerchantModel();
        $merchant_id = $merchant->id;
        $productManager = new ProductManager();
        $products = $productManager->listProducts($merchant_id);

        return $this->returnJson($products, true);
    }

    public function actionCollect() {
        $productId = Yii::$app->request->post('product_id');
        $user = $this->getUserModel();

        $isSuccess = UserCollections::add($user->id, $productId);
        return $this->returnJson([], $isSuccess);
    }

    public function actionDiscard() {
        $productId = Yii::$app->request->post('product_id');
        $user = $this->getUserModel();
        $isSuccess = UserCollections::discard($user->id, $productId);
        return $this->returnJson([], $isSuccess);
    }

    public function actionCategories() {
        $categories = ProductCategories::getAll();
        return $this->returnJson($categories, true);
    }

    public function actionAddMerchantCategory() {
        $name = Yii::$app->request->post('name');
        $merchant = $this->getMerchantModel();
        $model = new MerchantCategories();
        $model->merchant_id = 1;
        $model->name = $name;
        $model->save();
        if($model->errors) {
            Yii::error($model->errors);
        }
        return $this->returnJson([], $model->save());
    }

    public function actionMerchantCategories() {
        $merchant = $this->getMerchantModel();
        $merchantId = $merchant->id;
        $categories = MerchantCategories::all($merchantId);
        $result = [];
        foreach ($categories as $category) {
            $result[] = ['id' => $category->id, 'name' => $category->name];
        }

        return $this->returnJson($result, true);
    }

    public function actionUpdateMerchantCategory() {
        $form = Yii::$app->request->post('form');
        $merchant = $this->getMerchantModel();
        $merchant_id = $merchant->id;


        //如果用户没有提交已存在的有效类别，代表类别已被删除
        $categories = MerchantCategories::findAll(['merchant_id' => $merchant_id, 'status' => 1]);
        foreach ($categories as $category) {
            if(!array_key_exists($category->id, $form)){
                $categoryModel = MerchantCategories::findOne(['id' => $category->id]);
                $categoryModel->status = 0;
                $categoryModel->save();
            }
        }

        foreach ($form as $categoryId => $val) {
            //新添加的categoryId都是随机数
            $categoryModel = MerchantCategories::findOne(['id' => $categoryId]);
            if(!$categoryModel) {
                $categoryModel = new MerchantCategories();
                $categoryModel->merchant_id = $merchant_id;
            }
            $categoryModel->name = $val;
            $categoryModel->save();
        }

        return $this->returnJson([], true);
    }


}