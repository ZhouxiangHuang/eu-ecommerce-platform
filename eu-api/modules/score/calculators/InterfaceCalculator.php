<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/23
 * Time: 下午4:33
 */
namespace app\modules\score\calculators;

interface InterfaceCalculator
{
    public function calculate($merchantId);
}