<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 07/04/2017
 * Time: 11:04 PM
 */

namespace Module\Kernel\FileSystem\OSS;

use Upload\File;

/**
 * Class UploadFile
 * @package Module\Kernel\FileSystem\OSS
 */
class UploadFile extends File
{
    /**
     * 存储路径
     * @var string
     */
    protected $savePath;

    /**
     * @var
     */
    protected $protocol;

    /**
     * @return mixed
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param mixed $protocol
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getSavePath()
    {
        return $this->protocol . $this->savePath;
    }

    /**
     * @param string $savePath
     */
    public function setSavePath($savePath)
    {
        $this->savePath = $savePath;
    }


    /**
     * @param null $newName
     * @return bool
     */
    public function upload($newName = null)
    {
        $this->setSavePath($newName);
        return parent::upload($newName);
    }
}