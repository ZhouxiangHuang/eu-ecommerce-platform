<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/21
 * Time: 下午10:21
 */

namespace app\modules\site\controllers;


use app\modules\site\models\Merchants;
use app\modules\site\models\MerchantsTags;
use Yii;

class MerchantController extends BaseController
{
    public function actionUpdate() {
        $name = Yii::$app->request->post('name');
        $start = Yii::$app->request->post('start');
        $end = Yii::$app->request->post('end');
        $tags = Yii::$app->request->post('tags');
        $mobile = Yii::$app->request->post('mobile');
        $announcement = Yii::$app->request->post('announcement');
        $address = Yii::$app->request->post('address');

//        $merchant = $this->getMerchantModel();

        //save info
        $merchant = Merchants::findOne(['id' => 1]);
        $merchant->address = $address;
        $merchant->mobile = $mobile;
        $merchant->user_id = 1;
        $merchant->announcement = $announcement;
        $merchant->open_at = $start;
        $merchant->closed_at = $end;
        $merchant->store_name = $name;
        $merchant->save();
        if($merchant->errors) {
            Yii::error($merchant->errors);
        }

        //save tags
        //TODO: need optimize
        $merchantId = $merchant->id;
        $existingTagsModel = MerchantsTags::findAll(['merchant_id' => $merchantId]);
        $existingTags = [];

        foreach ($existingTagsModel as $model) {
            if(!in_array($model->tag_id, $tags)) {
                $model->status = 0;
                $model->save();
            }
            $existingTags[] = $model->tag_id;
        }
        foreach ($tags as $tagId) {
            if(!in_array($tagId, $existingTags)) {
                $model = new MerchantsTags();
                $model->tag_id = $tagId;
                $model->merchant_id = $merchantId;
                $model->save();
                if($model->errors) {
                    Yii::error($model->errors);
                }
            }
        }

        return $this->returnJson([], true);

    }
}