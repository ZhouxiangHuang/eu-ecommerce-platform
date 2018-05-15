<?php
namespace app\common;
use app\helpers\Oss;


require_once __DIR__ . '/../helpers/aliyun-oss-php-sdk-2.3.0/src/OSS/OssClient.php';

/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/3/3
 * Time: 下午3:57
 */
class DataSource implements DataSourceInterface
{
    public function storeImage($name, $path)
    {
       $oss = new Oss();
       return $oss->putObject($name, $path);
    }

}