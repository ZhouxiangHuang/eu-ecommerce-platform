<?php
namespace app\modules\site\interfaces;


/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:41
 */
/**
 * Interface ProductFactoryInterface
 * @package app\modules\site\interfaces
 */
interface ProductFactoryInterface
{
    static function create($productType);
}