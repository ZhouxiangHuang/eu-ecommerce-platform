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
        \Yii::error('start: '. microtime());

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
            if($category = self::belongTo($catId, $categories)) {
                if(array_key_exists($category['id'], $result)) {
                    $result[$category['id']] += $merchNum;
                } else {
                    $result[$category['id']] = 0;
                }
            }
        }
//
//        foreach ($tagCounter as $catId => $merchNum) {
//            foreach ($categories as $category) {
//                $found = self::findInTree($catId, $category);
//                if($found) {
//                    $result[$category['id']] += $merchNum;
//                } else {
//                    $result[$category['id']] = 0;
//                }
//            }
//        }

        \Yii::error('end: ' . microtime());
        return $result;
    }

    static function findInTree($categoryId, $tree) {
        if($tree['id'] == $categoryId) {
            return true;
        }

        if (count($tree['children']) == 0) {
            return false;
        } else {
            $found = false;
            foreach ($tree['children'] as $childTree) {
                $found = self::findInTree($categoryId, $childTree);
                if($found) break;
            }
            return $found;
        }
    }

    static function belongTo($categoryId, $categories) {
        foreach ($categories as $category) {
            $flattened = self::flattenCategory($category);
            foreach ($flattened as $val) {
                if($categoryId == $val['id']) {
                    return $category;
                }
            }
        }

        return false;
    }

    static function flattenCategory($cat) {
        $result = [];
        if(count($cat['children']) == 0) {
            return [$cat];
        } else {
            foreach ($cat['children'] as $child) {
                $result = array_merge($result, self::flattenCategory($child));
            }
        }

        return $result;
    }

}