<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 07/04/2017
 * Time: 8:27 PM
 */

namespace Module\Kernel\FileSystem\OSS;


use Module\Customer\Model\UserModel;
use Module\Kernel\Base\Object;
use Module\Kernel\Base\Container;
use Module\Kernel\FileSystem\Model\UploadModel;
use Module\Kernel\FileSystem\OSS\Aliyun\AliyunOss;
use Module\Kernel\Base\ToolRegisterInterface;
use Upload\Validation\Size;

/**
 * Class OSSTool
 * @package Module\Kernel\FileSystem\OSS
 */
class OSSTool extends Object implements ToolRegisterInterface
{
    public $protocol = "aliyun-oss://";

    /**
     * @param UserModel|null $userModel
     * @param $index
     * @param string $type
     * @param string $remark
     * @return UploadFile
     */
    public function uploadFile(UserModel $userModel = null,  $index, $type = "driveLicense", $remark = "")
    {
        $file = new UploadFile($index, AliyunOss::getInstance());

        $new_filename = uniqid();
        $file->setName($new_filename);
        $file->addValidations(array(
            new Size('5M')
        ));
        $dimensions = [];
        $vehicleLicenseImage = "{$type}/" . $file->getNameWithExtension();
        $data = array(
            'user_id' => $userModel ? $userModel->id : null,
            'remark' => $remark,
            'name' => $vehicleLicenseImage,
            'extension' => $file->getExtension(),
            'mime' => $file->getMimetype(),
            'size' => $file->getSize(),
            'md5' => $file->getMd5(),
            'width' => isset($dimensions['width']) ? $dimensions['width'] : 0,
            'height' => isset($dimensions['height']) ? $dimensions['height'] : 0,
        );
        // Success!
        $file->setProtocol($this->protocol);
        $file->upload($vehicleLicenseImage);
        $model = new UploadModel(UploadModel::getData($data));
        $model->save();
        return $file;
    }

    public function uploadFileContent()
    {

    }

    /**
     * 获取图片链接的可预览链接
     * @param $url
     * @return string
     */
    public function getImageUrl($url)
    {
        if (strpos($url, $this->protocol) !== false) {
            $url = str_replace($this->protocol, "", $url);
            return AliyunOss::getInstance()->getObjectUrl($url);
        } else {
            return $url;
        }
    }

    /**
     * 注册工具
     * @param Container $component
     * @return void
     */
    public static function register(Container $component)
    {
        $component->register("oss", self::className());
    }
}