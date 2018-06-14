<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/6/12
 * Time: 下午2:08
 */

namespace app\modules\site\models;


class SearchHelper
{
    public function findMerchantsBy($condition) {
        $countryCode = $condition['country_code'];
        $merchants = Merchants::findAll(['country' => $countryCode]);
        return $merchants;
    }
}