<?php
namespace app\modules\score\calculators;

use app\modules\site\models\Products;

/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/23
 * Time: 下午4:33
 */

class ProductScoreCalculator implements InterfaceCalculator
{
    public function calculate($merchantId)
    {
        $productNumber = Products::find()
            ->where(['merchant_id' => $merchantId])
            ->andWhere(['status' => 1])
            ->count();

        $score = $productNumber * 5;

        return $score;
    }
}