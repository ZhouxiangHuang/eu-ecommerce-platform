<?php
namespace app\modules\site\controllers;
use app\helpers\Security;
use app\helpers\WechatHelper;
use app\modules\site\models\Merchants;
use app\modules\site\models\ProductCategories;
use app\modules\site\models\Products;
use app\modules\site\models\User;
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
//    public function actionRegister() {
//        $code = Yii::$app->request->post('code');
//        $userWechatInfo = WechatHelper::userInfo($code);
//
//        return $this->returnJson($userWechatInfo, true);
//    }

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

        $accessToken = Security::generateAccessToken($userId);
        return $this->returnJson(['access_token' => $accessToken], true);
    }
    
}