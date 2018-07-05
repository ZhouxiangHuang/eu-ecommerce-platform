<?php
namespace app\modules\site\controllers;
use app\helpers\Security;
use app\helpers\WechatHelper;
use app\modules\site\models\Cities;
use app\modules\site\models\Countries;
use app\modules\site\models\Merchants;
use app\modules\site\models\MerchantsTags;
use app\modules\site\models\ProductCategories;
use app\modules\site\models\Products;
use app\modules\site\models\User;
use app\modules\site\models\UserCollections;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/4/23
 * Time: 下午3:52
 */
class UserController extends BaseController
{
    public function actionLogin() {
        $code = Yii::$app->request->post('code');
        $role = Yii::$app->request->post('role');
        $storeName = Yii::$app->request->post('store_name');
        $address = Yii::$app->request->post('address');
        $mobile = Yii::$app->request->post('mobile');

        $userWechatInfo = WechatHelper::userInfo($code);
        if(!$userWechatInfo) {
            return $this->returnJson([], false, '微信验证失败');
        }

        $openId = ArrayHelper::getValue($userWechatInfo, 'openid');
        $userId = User::getId($openId);
        if(!$userId) {
            User::register($openId);
            $userId = User::getId($openId);
        }

        if($role == User::ROLE_MERCHANT && !User::getMerchant($userId)) {
            if(!$storeName || !$address || !$mobile) {
                return $this->returnJson([], false, '缺少必要参数');
            }
            Merchants::register($userId, $storeName, $address, $mobile);
        }

        $merchant = User::getMerchant($userId);
        $merchantId = ($merchant && $role == User::ROLE_MERCHANT)  ? $merchant->id : null;

        User::updateLastLoginRole($userId, $role);
        $accessToken = Security::generateAccessToken($userId);
        return $this->returnJson(['access_token' => $accessToken, 'merchant_id' => $merchantId], true);
    }

    public function actionCountryCodes() {
        $countries = Countries::find()->where(['>', 'id', 0])->all();
        return $this->returnJson($countries, true);
    }

    public function actionRegions() {
        $countries = Countries::find()->all();
        $regions = [];
        foreach ($countries as $country) {
            $cities = Cities::findAll(['country_code' => $country->country_code]);
            $cities[] = [
                'country_code' => $country->country_code,
                'name' => '其他',
                'city_code' => 'OTHER'
            ];
            $countryArr = [];
            $countryArr['name'] = $country->name;
            $countryArr['country_code'] = $country->country_code;
            $countryArr['children'] = $cities;
            $regions[] = $countryArr;
        }

        return $this->returnJson($regions, true);
    }

    public function actionValidate() {
        $code = Yii::$app->request->post('code');
        $userWechatInfo = WechatHelper::userInfo($code);
        if(!$userWechatInfo) {
            return $this->returnJson([], false, '微信验证失败');
        }

        $openId = ArrayHelper::getValue($userWechatInfo, 'openid');
        $user = User::findOne(['wx_open_id' => $openId]);
        if(!$user) {
            return $this->returnJson([], false, '未注册用户');
        }

        $userId = $user->id;
        $merchant = User::getMerchant($userId);
        $isMerchant = $merchant !== null;
        $accessToken = Security::generateAccessToken($userId);

        $merchantId = $isMerchant ? $merchant->id : null;
        $merchantProfile = $isMerchant ? $merchant->getProfile() : null;
        $merchantName = $isMerchant ? $merchant->store_name : null;

        return $this->returnJson([
                'access_token' => $accessToken,
                'has_merchant_id' => $isMerchant,
                'merchant_id' => $merchantId,
                'last_login_role' => $user->last_login_role,
                'profile' => $merchantProfile,
                'store_name' => $merchantName
            ]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionCollections() {
        $user = $this->getUserModel();
        $collections = UserCollections::all($user->id);

        return $this->returnJson($collections);
    }

    public function actionTelCodes() {
        $codes = Countries::getTelCodes();
        return $this->returnJson($codes);
    }

    public function actionTest() {
        return MerchantsTags::findTagRoot(24);
    }
}