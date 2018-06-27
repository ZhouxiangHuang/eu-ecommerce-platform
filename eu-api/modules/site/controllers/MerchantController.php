<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/21
 * Time: 下午10:21
 */

namespace app\modules\site\controllers;

use app\helpers\Security;
use app\modules\site\models\Cities;
use app\modules\site\models\Countries;
use app\modules\site\models\Currency;
use app\modules\site\models\MerchantCategories;
use app\modules\site\models\Merchants;
use app\modules\site\models\MerchantsTags;
use app\modules\site\models\User;
use Yii;
use yii\helpers\ArrayHelper;

class MerchantController extends BaseController
{
    public function actionList($page = 0, $country = null, $category = null) {
        $merchants = Merchants::all($page, $country, $category);
        return $this->returnJson($merchants);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionUpdate() {
        $name = Yii::$app->request->post('store_name');
        $start = Yii::$app->request->post('start');
        $end = Yii::$app->request->post('end');
        $tags = Yii::$app->request->post('tags');
        $mobile = Yii::$app->request->post('mobile');
        $announcement = Yii::$app->request->post('announcement');
        $address = Yii::$app->request->post('address');
        $country = Yii::$app->request->post('country_code');
        $city = Yii::$app->request->post('city_code');
        $currencyId = Yii::$app->request->post('currency_id');

        /** @var Merchants $merchant */
        $merchant = $this->getMerchantModel();
        $merchant->address = $address;
        $merchant->mobile = $mobile;
        $merchant->user_id = $this->getUserModel()->id;
        $merchant->announcement = $announcement;
        $merchant->open_at = $start;
        $merchant->closed_at = $end;
        $merchant->store_name = $name;
        $merchant->country = $country;
        $merchant->city = $city;
        $merchant->currency_id = $currencyId;
        $merchant->save();
        if($merchant->errors) {
            Yii::error($merchant->errors);
        }

        //save tags
        //TODO: need optimize
        $merchantId = $merchant->id;
        $existingTagsModel = MerchantsTags::getAllTags($merchantId);
        $existingTags = [];

        foreach ($existingTagsModel as $array) {
            $model = MerchantsTags::findOne(['id' => $array['id']]);
            if(!in_array($array['tag_id'], $tags)) {
                /** @var MerchantsTags $model */
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

    public function actionDetail($merchant_id) {
        $merchant = Merchants::findOne(['id' => $merchant_id]);
        $array = [];
        $countryModel = Countries::findByCode($merchant->country);
        $cityModel = Cities::findByCode($merchant->city);
        $array['store_name'] = $merchant->store_name;
        $array['image_url'] = $merchant->getProfile();
        $array['open_at'] = $merchant->open_at;
        $array['closed_at'] = $merchant->closed_at;
        $array['mobile'] = $merchant->mobile;
        $array['announcement'] = $merchant->announcement;
        $array['address'] = $merchant->address;
        $array['country_code'] = $merchant->country;
        $array['city_code'] = $merchant->city;
        $array['address'] = $merchant->address;
        $array['currency'] = $merchant->getCurrency();
        $array['region'] = ArrayHelper::getValue($countryModel, 'name') . '/' . ArrayHelper::getValue($cityModel, 'name');
        $array['tags'] = MerchantsTags::getAllTags($merchant->id);

        return $this->returnJson($array, true);
    }

    public function actionCategories() {
        $merchant = $this->getMerchantModel();
        $categories = MerchantCategories::all($merchant->id);
        $result = [];
        /** @var MerchantCategories $category */
        foreach ($categories as $category) {
            $model = [];
            $model['id'] = $category->id;
            $model['name'] = $category->name;
            $result[] = $model;
        }
        return $this->returnJson($result);
    }

    public function actionUploadProfile() {
        /** @var Merchants $merchant */
        $merchant = $this->getMerchantModel();
        $isSuccess = $merchant->addProfile('file');
        return $this->returnJson([], $isSuccess);
    }

    public function actionRegisteredCountries() {
        $countries = Merchants::registeredCountries();
        return $this->returnJson($countries);
    }

    public function actionCurrencies() {
        $cuurentcies = Currency::findAll(['status' => 1]);
        return $this->returnJson($cuurentcies);
    }

    public function actionGenerateTestingMerchants() {
        for($i = 0; $i < 50; $i++) {
            $fakeUserId = time();
            User::register($fakeUserId);
            Merchants::register($fakeUserId, 'store' . $i, 'fake address', '1234567');
        }
    }

    public function actionTest() {
        $merchant = Merchants::findOne(['id' => 51]);
        $result = $merchant->getProductPeeks();

        return $this->returnJson($result);
    }
}