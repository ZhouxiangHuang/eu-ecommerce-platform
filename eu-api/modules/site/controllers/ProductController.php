<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:45
 */

namespace app\modules\site\controllers;


use app\modules\site\models\Products;
use app\modules\site\models\User;
use app\modules\site\ProductFactory;
use Yii;
use yii\web\UploadedFile;

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

        $result = ProductFactory::create($form);
        if($result) {
            $this->returnJson([], true);
        } else {
            $this->returnJson([], false);
        }
    }

    public function actionDetail($product_id) {
        $product = Products::detail($product_id);
        $this->returnJson($product, true);
    }

    public function actionProducts() {
        $user = $this->getUserModel();
        $merchant = User::getMerchant($user->id);
        $merchant_id = $merchant->id;

        $products = Products::all($merchant_id);
        $this->returnJson($products, true);
    }

    public function actionUpload() {
        Yii::error($_FILES['file']['tmp_name']);
        Yii::error($_FILES['file']['name']);

        $contentUploaded = UploadedFile::getInstanceByName('file');
        $contentUploaded->saveAs('/tmp/' . $_FILES['file']['name']);
        
    }

}