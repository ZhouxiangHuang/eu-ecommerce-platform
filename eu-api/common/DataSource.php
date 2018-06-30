<?php
namespace app\common;
use app\helpers\Oss;
use common\modules\file_system\oss\OSSQiniuTool;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/3/3
 * Time: 下午3:57
 */
class DataSource implements DataSourceInterface
{
    /** @var Oss $oss */
    private $oss;

    public function __construct()
    {
        $this->oss = new OSS();
    }

    public function storeImage($fileName)
    {
        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $dateTime = time() . rand(111, 999);
        $name = 'wx_' . $dateTime . '.' . $ext;

        $contentUploaded = UploadedFile::getInstanceByName($fileName);
        $contentUploaded->saveAs($path = '/tmp/' . $name);

        $isSuccess = $this->oss->putObject($name, $path);

        if($isSuccess) {
            unlink($path);
        }

        return $isSuccess;
    }

    public function storeQrCode($path , $name) {
        if(!$name) {
            $dateTime = time() . rand(111, 999);
            $name = 'wx_' . $dateTime . '.jpg';
        }

        $isSuccess = $this->oss->putObject($name, $path);
        if($isSuccess) {
            unlink($path);
        }

        return $isSuccess;
    }

    public function getImageUrl($fileName) {
        return $this->oss->getUrl($fileName);
    }
}