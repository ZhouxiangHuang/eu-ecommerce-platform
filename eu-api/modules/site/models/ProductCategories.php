<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "product_categories".
 *
 * @property int $id
 * @property string $name 种类名
 * @property int $type
 * @property int $parent_id
 */
class ProductCategories extends \yii\db\ActiveRecord
{
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
}
