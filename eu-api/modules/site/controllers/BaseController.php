<?php

namespace app\modules\site\controllers;
date_default_timezone_set("Asia/Shanghai");

use app\modules\site\models\User;
use Exception;
use Firebase\JWT\JWT;
use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

/**
 * Created by PhpStorm.
 * User: air
 * Date: 23/01/2018
 * Time: 5:05 PM
 */
class BaseController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'common\web\ErrorAction',
            ],
        ];
    }

    public static function allowedDomains()
    {
        return [
            '*',                        // star allows all domains
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['POST', 'GET', 'OPTIONS', 'PUT'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                    'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept', 'Access-Token', 'Access-Control-Allow-Origin', 'X_Requested_With'],
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
//                    'Access-Control-Expose-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept'],
                ],
            ],

        ]);
    }

    /**
     * @param null $data
     * @param bool $isSuccess
     * @param string $msg
     * @param Pagination $pagination
     * @return array
     */
    public function returnJson($data = null, $isSuccess = true, $msg = "请求成功", Pagination $pagination = null)
    {

        $data = [
            "result_code" => $isSuccess !== null && $isSuccess !== false && $isSuccess !== true ? $isSuccess : ($isSuccess ? 10000 : 15000),
            "reason" => $msg,
            "result" => $data === null ? [] : $data,
        ];
        if ($pagination) {
            $data['page'] = $pagination;
        }

        $callback = Yii::$app->request->get("callback");
        Yii::$app->getResponse()->format =
            (is_null($callback)) ?
                Response::FORMAT_JSON :
                Response::FORMAT_JSONP;
        // return data
        return (is_null($callback)) ?
            $data :
            array(
                'data' => $data,
                'callback' => $callback
            );
    }

    /**
     * @param null $data
     * @return array
     */
    public function returnRawJson($data = null)
    {
        $callback = Yii::$app->request->get("callback");
        Yii::$app->getResponse()->format =
            (is_null($callback)) ?
                Response::FORMAT_JSON :
                Response::FORMAT_JSONP;
        // return data
        return (is_null($callback)) ?
            $data :
            array(
                'data' => $data,
                'callback' => $callback
            );
    }


    /**
     * @param $error
     * @return string
     */
    public function parseError($error)
    {
        if (is_array($error)) {
            $msg = [];
            foreach ($error as $item) {
                $msg[] = implode(",", $item);
            }
            return implode(",", $msg);
        } else {
            return "请求错误";
        }
    }

    public function params()
    {
        return array_merge(Yii::$app->request->get(), Yii::$app->request->post());
    }


    /**
     * @return User
     * @throws \yii\base\Exception
     */
    public function getUserModel()
    {
        try {
            $accessToken = Yii::$app->request->headers->get("access-token");
            if ($accessToken && $accessToken !== "null") {
                $decoded = JWT::decode($accessToken, file_get_contents(__DIR__ . "/../../../helpers/cert/public_key.pem"), array('RS256'));
                $decoded_array = (array)$decoded;
                if (ArrayHelper::getValue($decoded_array, "uid") && ArrayHelper::getValue($decoded_array, "time")) {
                    $userId = intval(ArrayHelper::getValue($decoded_array, "uid"));
                    $static = User::findOne($userId);
                    if ($static) {
                        return $static;
                    } else {
                        throw new UnauthorizedHttpException("User does not exist.");
                    }
                } else {
                    throw new UnauthorizedHttpException("Access Denied.");
                }
            } else {
                throw new UnauthorizedHttpException("Access Denied.");

            }
        } catch (\Exception $e) {
            Yii::error($e);
            throw new UnauthorizedHttpException("Access Denied.");
        }
    }

    public function getMerchantModel() {
        try {
            $userModel = $this->getUserModel();
            $merchantModel = User::getMerchant($userModel->id);
            if(!$merchantModel) {
                throw new UnauthorizedHttpException("Not a merchant.");
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
        }
        return $merchantModel;
    }

    protected function getErrorMessage(Model $model)
    {
        $firstErrors = $model->getFirstErrors();
        if (count($firstErrors) > 0) {
            return array_shift($firstErrors);
        } else {
            return 'Fail Request.';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        $authenticated = true;
        $authorized = true;
        if($authenticated && $authorized) {
            return true;
        } else {
            return false;
        }
    }
    
}