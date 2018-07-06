<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/6
 * Time: 下午12:56
 */

namespace app\helpers;


/**
 * Class DataStructure
 * @package app\helpers
 * @return boolean
 */
class DataStructure
{

    static function findInTree($targetId, $tree) {
        if($tree['id'] == $targetId) {
            return true;
        }

        if (count($tree['children']) == 0) {
            return false;
        } else {
            $found = false;
            foreach ($tree['children'] as $childTree) {
                $found = self::findInTree($targetId, $childTree);
                if($found) break;
            }
            return $found;
        }
    }
}