<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "merchants_tags".
 *
 * @property int $id
 * @property int $status
 * @property string $tag_id 商户名
 * @property string $merchant_id 开店时间
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class MerchantsTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchants_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id'], 'required'],
            [['merchant_id', 'created_at', 'updated_at'], 'safe'],
            [['tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag ID',
            'merchant_id' => 'Merchant ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function getTagIds($merchantId) {
        $models = MerchantsTags::findAll(['merchant_id' => $merchantId, 'status' => 1]);
        $result = [];

        foreach ($models as $model) {
            $result[] = $model->tag_id;
        }

        return $result;
    }

    static function getTagNames($merchantId) {
        $models = MerchantsTags::findAll(['merchant_id' => $merchantId, 'status' => 1]);
        $result = [];

        foreach ($models as $model) {
            $model = ProductCategories::findOne(['id' => $model->tag_id]);
            $result[] = $model->name;
        }

        return $result;
    }

    static function getAllTags($merchantId) {
        $models = MerchantsTags::findAll(['merchant_id' => $merchantId, 'status' => 1]);

        $tags = [];
        foreach ($models as $model) {
            $tag = ProductCategories::findOne(['id' => $model->tag_id]);
            $name = $tag->name;
            $array = [
                'id' => $model->id,
                'name' => $name,
                'tag_id' => $model->tag_id,
                'parent_id' => MerchantsTags::findTagRoot($tag->parent_id)
            ];
            array_push($tags, $array);
        }

        return $tags;
    }

    static function getAllTagNames($merchantId) {
        $models = MerchantsTags::findAll(['merchant_id' => $merchantId, 'status' => 1]);
        $array = [];
        foreach ($models as $model) {
            $category = ProductCategories::findOne(['id' => $model->tag_id]);
            $array[] = $category->name;
        }

        return $array;
    }

    static function findTagRoot($tagId) {
        $model = ProductCategories::findOne(['id' => $tagId]);
        if($model->parent_id == 0) {
            return $model->id;
        } else {
            return MerchantsTags::findTagRoot($model->parent_id);
        }
    }

    //TODO: need optimize
    static function findChildrenTags($parentId) {
        $children = ProductCategories::findAll(['parent_id' => $parentId]);
        if(empty($children)) {
            return $parentId;
        } else {
            $result = [];
            foreach ($children as $child) {
                $childrenIds = MerchantsTags::findChildrenTags($child->id);
                if(is_array($childrenIds)){
                    foreach ($childrenIds as $childrenId) {
                        array_push($result, $childrenId);
                    }
                } else {
                    array_push($result, $childrenIds);
                }
            }
            return $result;
        }
    }
}
