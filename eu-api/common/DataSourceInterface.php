<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/14
 * Time: 下午11:23
 */

namespace app\common;


interface DataSourceInterface
{
    public function storeImage($name, $path);
}