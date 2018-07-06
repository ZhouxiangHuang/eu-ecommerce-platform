<?php

namespace app\modules\site\models;

use app\helpers\Stats;
use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property int $id
 * @property string $name 种类名
 * @property int $type
 * @property int $parent_id
 * @property array $children
 */
class ProductCategories extends \yii\db\ActiveRecord
{
    public $children = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'parent_id'], 'required'],
            [['type', 'parent_id'], 'integer'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'parent_id' => 'Parent ID',
        ];
    }

    static function getAll($parentId = 0) {
        $products = ProductCategories::findAll(['parent_id' => $parentId]);

        if(empty($products)) {
            $category = ProductCategories::findOne(['id' => $parentId]);
            return ['id' => $parentId, 'name' => $category->name, 'children' => []];
        } else {
            $result = [];
            foreach ($products as $product) {
                $result[] = ['children' => self::getAll($product->id), 'name' => $product->name, 'id' => $product->id];
            }
            return $result;
        }

    }

    static function getAllV2() {
        $products = ProductCategories::find()->orderBy('parent_id desc')->all();
        $productsArray = [];
        foreach ($products as $product) {
            /** @var ProductCategories $product */
            $productsArray[] = [
                'id' => $product->id,
                'parent_id' => $product->parent_id,
                'name' => $product->name,
                'children' => [],
            ];
        }

        $sortedProduct = self::sortProducts($productsArray);
        $merchInCategories = Stats::countMerchantsInCategories($sortedProduct);
        for ($i = 0; $i < count($sortedProduct); $i++) {
            $catId = $sortedProduct[$i]['id'];
            if(array_key_exists($catId, $merchInCategories)) {
                $sortedProduct[$i]['merchant_count'] = $merchInCategories[$catId];
            } else {
                $sortedProduct[$i]['merchant_count'] = 0;
            }
        }

        return $sortedProduct;
    }

    static function sortProducts($productCategories = []) {

        $start = 0;
        for($i = 0; $i < count($productCategories); $i++) {
            $child = $i;
            $cCategory = $productCategories[$child];
            if($cCategory['parent_id'] == 0) {
                $start = $i;
                break;
            }
            for ($j = $i + 1; $j < count($productCategories); $j++) {
                $parent = $j;
                $pCategory = $productCategories[$parent];
                if($cCategory['parent_id'] == $pCategory['id']) {
                    $pCategory['children'][] = $cCategory;
                    $productCategories[$parent] = $pCategory;
                    break;
                }
            }

        }

        return array_slice($productCategories, $start);
    }

}
