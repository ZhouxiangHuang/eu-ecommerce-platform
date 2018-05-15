<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/14
 * Time: 下午11:47
 */

namespace app\helpers;


use OSS\Core\OssException;
use OSS\OssClient;

class Oss
{
    private $bucket;
    private $accessId;
    private $accessKey;
    private $endpoint;

    function __construct()
    {
        $app = \Yii::$app;
        $this->bucket = $app->params['oss']['bucket'];
        $this->accessId = $app->params['oss']['access_id'];
        $this->accessKey = $app->params['oss']['key'];
        $this->endpoint = $app->params['oss']['endpoint'];
    }

    public function putObject($uniqueName, $path) {
        $ossClient = new OssClient($this->accessId, $this->accessKey, $this->endpoint);
        $content = file_get_contents($path);

        try{
            $ossClient->putObject($this->bucket, $uniqueName, $content);
        } catch(OssException $e) {
            \Yii::error(__FUNCTION__ . ": FAILED\n");
            \Yii::error($e->getMessage() . "\n");
            return false;
        }
        return true;
    }
}