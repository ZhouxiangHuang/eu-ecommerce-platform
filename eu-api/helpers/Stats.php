<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/5
 * Time: 下午5:20
 */

namespace app\helpers;


use app\modules\site\models\MerchantsTags;

class Stats
{
    static function countMerchantsInCategories($categories) {
        $tagCounter = []; //key tagId(categoryId) : value number of merchants
        $merchantTags = MerchantsTags::find()->all();
        foreach ($merchantTags as $tag) {
            if(array_key_exists($tag->tag_id, $tagCounter)) {
                $tagCounter[$tag->tag_id]++;
            } else {
                $tagCounter[$tag->tag_id] = 1;
            }
        }

        $result = [];
        foreach ($tagCounter as $catId => $merchNum) {
            foreach ($categories as $category) {
                $found = DataStructure::findInTree($catId, $category);
                if($found) {
                    $result[$category['id']] += $merchNum;
                } else {
                    $result[$category['id']] = 0;
                }
            }
        }

        return $result;
    }

}