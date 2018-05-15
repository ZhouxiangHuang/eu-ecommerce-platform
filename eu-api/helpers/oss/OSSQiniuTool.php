<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 5/10/17
 * Time: 4:05 PM
 */

namespace common\modules\file_system\oss;


use Module\Customer\Model\UserModel;
use Module\Kernel\Base\Object;
use Module\Kernel\Base\Container;
use Module\Kernel\FileSystem\Model\UploadModel;
use Module\Kernel\FileSystem\OSS\Aliyun\QiniuOss;
use Module\Kernel\Base\ToolRegisterInterface;
use Upload\Validation\Size;

class OSSQiniuTool extends Object implements ToolRegisterInterface
{

    /**
     * 注册工具
     * @param Container $component
     * @return void
     */
    public static function register(Container $component)
    {
        $component->register("oss_qiniu", self::className());
    }

    /**
     * @param UserModel|null $userModel
     * @param $index
     * @param string $type
     * @param string $remark
     * @return UploadFile
     */
    public function uploadFile(UserModel $userModel = null, $index, $type = "driveLicense", $remark = "")
    {
        $file = new UploadFile($index, QiniuOss::getInstance());

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
        $file->upload($vehicleLicenseImage);
        $model = new UploadModel(UploadModel::getData($data));
        $model->save();
        return $file;
    }

    /**
     * 获取图片链接的可预览链接
     * @param $url
     * @return string
     */
    public function getImageUrl($url)
    {
        return $url;
    }
}