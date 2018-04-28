<?php
namespace app\modules\site\controllers;
use app\helpers\Security;
use app\modules\site\models\User;
use Yii;
use yii\filters\AccessControl;

/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/4/23
 * Time: 下午3:52
 */
class UserController extends BaseController
{
    public function actionTest() {
        return 'Hello World!';
    }

    public function actionRegister() {
        $mobile = Yii::$app->request->post('mobile');
        $role = Yii::$app->request->post('role');

        if(User::createNewUser($mobile, $role)) {
            $message = '注册成功';
            $isSuccess = true;
        } else {
            $message = '注册账户失败';
            $isSuccess = false;
        }

        return $this->returnJson([], $isSuccess, $message);
    }

    public function actionLogin() {
        $mobile = Yii::$app->request->post('mobile');

        if(User::isValid($mobile)) {
            $userId = User::findIdByMobile($mobile);
            $accessToken = Security::generateAccessToken($userId);
            $data = ['access_token' => $accessToken];
            return $this->returnJson($data, true);
        } else {
            $this->returnJson([], false, '登陆失败');
        }
    }
    
}