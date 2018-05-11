<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 16/9/11
 * Time: 下午2:33
 */

namespace app\helpers;

class WechatHelper
{
    /**
     * @param bool|false $refresh
     * @return bool
     */
    public static function accessToken($refresh = false)
    {
        $cacheName = "WechatAccessToken";
        if ($accessToken = \Yii::$app->cache->get($cacheName) && !$refresh) {

        } else {
            $response = \Requests::get("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . \Yii::$app->params['wechat']["appid"] . "&secret=" . \Yii::$app->params['wechat']["secret"]);
            $response = json_decode($response->body, true);
            $accessToken = $response["access_token"];
            \Yii::$app->cache->set($cacheName, $accessToken, 6000);
        }

        return $accessToken;
    }

    public static function userInfo($code, $refresh = false)
    {

        $response = \Requests::get("https://api.weixin.qq.com/sns/jscode2session?appid=". 'wxe2192bf1c03375fe' ."&secret=".'fbe134eca96b3a9ad1d6b128a6404ed8'."&grant_type=client_credential&js_code=" .$code);
        $response = json_decode($response->body, true);

        return $response;
    }

    /**
     * @return false|mixed|null
     */
    public static function jsApiTicket()
    {
        $cacheName = "WechatJSTicket";
        if ($accessToken = \Yii::$app->cache->get($cacheName)) {

        } else {
            $response = \Requests::get("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . self::accessToken() . "&type=jsapi");
            $response = json_decode($response->body, true);
            if (!isset($response["ticket"])) {
                \Yii::$app->cache->set("WechatAccessToken", null);
                return null;
            }
            $accessToken = $response["ticket"];
            \Yii::$app->cache->set($cacheName, $accessToken, 6000);
        }

        return $accessToken;
    }

    /**
     * @return array
     */
    public static function jsApiSignature()
    {
        // 注意 URL 一定要动态获取.
        $protocol = CommonHelper::currentProtocol();
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $result = [
            "jsapi_ticket" => self::jsApiTicket(),
            "noncestr" => uniqid(),
            "timestamp" => time(),
            "url" => $url,
        ];
        $str = [];
        foreach ($result as $k => $v) {
            $str[] = $k . "=" . $v;
        }

        $return = [
            "debug" => false,
            "appId" => \Yii::$app->params['wechat']["appid"],
            "timestamp" => $result["timestamp"],
            "nonceStr" => $result["noncestr"],
            "signature" => sha1(implode("&", $str)),
            "jsApiList" => [
                "onMenuShareTimeline",
                "onMenuShareAppMessage",
                "onMenuShareWeibo",
                "onMenuShareQQ",
            ],
        ];

        return $return;
    }
}