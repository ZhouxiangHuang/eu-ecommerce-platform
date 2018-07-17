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

require __DIR__ . '/aliyun-oss-php-sdk-2.3.0/src/OSS/OssClient.php';
class Oss
{
    private $bucket;
    private $accessId;
    private $accessKey;
    private $endpoint;

    private $client;

    function __construct()
    {
        $app = \Yii::$app;
        if(isProduction()) {
            $this->bucket = $app->params['oss']['production-bucket'];
            $this->endpoint = $app->params['oss']['production-endpoint'];
        } else {
            $this->bucket = $app->params['oss']['test-bucket'];
            $this->endpoint = $app->params['oss']['test-endpoint'];
        }
        $this->accessId = $app->params['oss']['access_id'];
        $this->accessKey = $app->params['oss']['key'];

        \Yii::error($this->bucket);

        try {
            $this->client = new OssClient($this->accessId, $this->accessKey, $this->endpoint, true);
        } catch (OssException $e) {
            \Yii::error($e->getMessage() . "\n");
        }
    }

    public function putObject($uniqueName, $path) {
        try{
            $content = file_get_contents($path);
            $this->client->putObject($this->bucket, $uniqueName, $content);
        } catch(OssException $e) {
            \Yii::error(__FUNCTION__ . ": FAILED\n");
            \Yii::error($e->getMessage() . "\n");
            return false;
        }
        return true;
    }

    public function getUrl($uniqueName, $time = 3600) {
        try{
            if(isProduction()) {
                $this->client->setUseSSL(true);
            }
            return $this->client->signUrl($this->bucket, $uniqueName, $time);
        } catch(OssException $e) {
            \Yii::error(__FUNCTION__ . ": FAILED\n");
            \Yii::error($e->getMessage() . "\n");
            return false;
        }
    }
}