<?php
/**
 * Created by PhpStorm.
 * User: air
 * Date: 15/5/14
 * Time: 下午5:22
 */

namespace Module\Kernel\FileSystem\OSS\Aliyun;

use Module\Kernel\Base\Object;

class Config extends Object
{
    public $bucket;

    public $timeout = 3600;
}