<?php
namespace app\helpers;

use Firebase\JWT\JWT;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/4/23
 * Time: PM11:34
 */
class Security
{
    static function generateAccessToken($user_id) {
        $accessToken = JWT::encode([
            'uid' => $user_id,
            'time' => time(),
        ], file_get_contents(__DIR__ . "/../cert/private_key.pem"), 'RS256');
        
        return $accessToken;
    }
    
    static function validateAccessToken($token) {
        $decoded = JWT::decode($token, file_get_contents(__DIR__ . "/../../api/cert/public_key.pem"), array('RS256'));
        $decoded_array = (array)$decoded;
        if (ArrayHelper::getValue($decoded_array, "uid") && ArrayHelper::getValue($decoded_array, "time")) {
            return true;
        } else {
            return false;
        }
    }
    
    static function validateAuthority($token, $action) {
        $decoded = JWT::decode($token, file_get_contents(__DIR__ . "/../../api/cert/public_key.pem"), array('RS256'));
        $decoded_array = (array)$decoded;
        $userId = ArrayHelper::getValue($decoded_array, "uid");

        $rules = \Yii::$app->params['rules'];
    }
    
}