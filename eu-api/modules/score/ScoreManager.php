<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/23
 * Time: 下午4:32
 */
namespace app\modules\score;

use app\modules\score\calculators\InterfaceCalculator;
use app\modules\score\calculators\ProductScoreCalculator;
use app\modules\site\models\Merchants;
use yii\log\Logger;

class ScoreManager
{
    private $calculators = [];

    public function __construct()
    {
        array_push($this->calculators, new ProductScoreCalculator());
    }

    public function run() {
        $merchants = Merchants::find()
            ->where(['status' => 1])
            ->all();

        foreach ($merchants as $merchant) {
            /** @var Merchants $merchant */
            echo'Merchant ID: ___' . $merchant->id . '___' . PHP_EOL;
            $totalScore = 0;
            foreach ($this->calculators as $calculator) {
                /** @var InterfaceCalculator $calculator */
                $score = $calculator->calculate($merchant->id);
                $totalScore += $score;
            }

            echo 'Merchant ID: ___' . $merchant->id . '___total:' . $totalScore . PHP_EOL;
            $merchant->score = $totalScore;
            $merchant->save();
        }
    }

}