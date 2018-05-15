<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:45
 */

namespace app\modules\site\controllers;


use app\common\DataSource;
use app\modules\site\models\Products;
use app\modules\site\models\User;
use app\modules\site\ProductFactory;
use Yii;
use yii\web\UploadedFile;

class ProductController extends BaseController
{
    public function actionCreate() {

        $form = [
            'file_name' => Yii::$app->request->post('file_name'),
            'type' => Yii::$app->request->post('type'),
            'price' => Yii::$app->request->post('price'),
            'code' => Yii::$app->request->post('code'),
            'hot' =>  Yii::$app->request->post('hot'),
            'description' => Yii::$app->request->post('description'),
            'image_only' => Yii::$app->request->post('image_only')
        ];

        $isSuccess = ProductFactory::create($form);
        return $this->returnJson([], $isSuccess);
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

//    public function actionUpload() {
//        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//        $dateTime = time() . rand(111, 999);
//        $name = 'wx_' . $dateTime . '.' . $ext;
//
//        $contentUploaded = UploadedFile::getInstanceByName('file');
//        $contentUploaded->saveAs($path = '/tmp/' . $name);
//
//        $dataSource = new DataSource();
//        $isSuccess = $dataSource->storeImage($name, $path);
//
//        if($isSuccess) {
//            unlink($path);
//        }
//    }

}