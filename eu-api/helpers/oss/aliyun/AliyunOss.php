<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 15/5/14
 * Time: 下午4:50
 */

namespace Module\Kernel\FileSystem\OSS\Aliyun;

use Slim\Slim;
use Upload\Storage\Base;

/**
 * Class AliyunOss
 * @package Module\Kernel\FileSystem\OSS\Aliyun
 */
class AliyunOss extends Base
{
    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $service;

    /**
     * @return \Module\Kernel\FileSystem\OSS\Aliyun\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Module\Kernel\FileSystem\OSS\Aliyun\Config $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return ALIOSS
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param ALIOSS $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }


    /**
     * AliyunOss constructor.
     * @param null $attributes
     */
    public function __construct($attributes = null)
    {
        require_once __DIR__ . '/sdk.class.php';

        $config = Slim::getInstance()->config("oss");
        $this->setService(new ALIOSS($config['ACCESS_ID'], $config['ACCESS_KEY'], $config['DEFAULT_OSS_HOST']));
        $this->setConfig(new Config());
        //设置是否打开curl调试模式
        $this->getService()->set_debug_mode(FALSE);
    }


    /**
     * @return AliyunOss
     */
    public static function getInstance()
    {
        $oss = new AliyunOss();
        $oss->setConfig(new Config(Slim::getInstance()->config("oss")));
        return $oss;
    }


    /**
     * @param \Upload\File $file
     * @param null $newName
     * @return bool
     */
    public function upload(\Upload\File $file, $newName = null)
    {
        if (is_string($newName)) {
            $fileName = strpos($newName, '.') ? $newName : $newName . '.' . $file->getExtension();

        } else {
            $fileName = $file->getNameWithExtension();
        }

        $content = file_get_contents($file->getPathname());

        $upload_file_options = array(
            'content' => $content,
            'length' => strlen($content),
        );

        $this->getService()->upload_file_by_content($this->getConfig()->bucket, $fileName, $upload_file_options);
        return true;
    }

    /**
     * @param $objectName
     * @return string
     */
    public function getObjectUrl($objectName)
    {
        $bucket = $this->getConfig()->bucket;
        $timeout = $this->getConfig()->timeout;
        $response = $this->getService()->get_sign_url($bucket, $objectName, $timeout);
        return $response;
    }

    /**
     * @param $objectName
     * @return string
     */
    public function getImage($objectName)
    {
        $bucket = $this->getConfig()->bucket;
        $timeout = $this->getConfig()->timeout;
        $options = [];
        return $this->getService()->get_object($bucket, $objectName, $options)->body;
    }
}