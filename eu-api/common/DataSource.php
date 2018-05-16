<?php
namespace app\common;
use app\helpers\Oss;
use yii\web\UploadedFile;


require_once __DIR__ . '/../helpers/aliyun-oss-php-sdk-2.3.0/src/OSS/OssClient.php';

/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/3/3
 * Time: 下午3:57
 */
class DataSource implements DataSourceInterface
{
    public function storeImage($fileName)
    {
        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $dateTime = time() . rand(111, 999);
        $name = 'wx_' . $dateTime . '.' . $ext;

        $contentUploaded = UploadedFile::getInstanceByName($fileName);
        $contentUploaded->saveAs($path = '/tmp/' . $name);

        $oss = new Oss();
        $isSuccess = $oss->putObject($name, $path);

        if($isSuccess) {
            unlink($path);
        }

        return $isSuccess;
    }

}