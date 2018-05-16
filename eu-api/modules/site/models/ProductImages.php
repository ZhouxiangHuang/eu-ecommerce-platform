<?php

namespace app\modules\site\models;

use app\helpers\Oss;
use Yii;

/**
 * This is the model class for table "product_images".
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $unique_name
 * @property string $url
 * @property string $expired_at
 * @property string $created_at
 * @property string $updated_at
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['unique_name'], 'required'],
            [['expired_at', 'created_at', 'updated_at'], 'safe'],
            [['unique_name'], 'string', 'max' => 30],
            [['url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'unique_name' => 'Unique Name',
            'url' => 'Url',
            'expired_at' => 'Expired At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function create($productId, $name, $time) {
        $oss = new Oss();
        $model = new ProductImages();
        $model->product_id = $productId;
        $model->unique_name = $name;
        $model->url = $oss->getUrl($name, $time);
        $model->expired_at = date('Y-m-d H:i:s', time() + $time);
        $model->save();

        if($model->errors) {
            Yii::error($model->errors);
            return false;
        } else {
            return true;
        }
    }

    static function getImages($productId) {
        $urls = [];
        $images = ProductImages::findAll(['product_id' => $productId]);
        foreach ($images as $model)
        {
            $isExpired = date('Y-m-d H:i:s', time()) > $model->expired_at;
            if($isExpired) {
                $oss = new Oss();
                $model->url = $oss->getUrl($model->unique_name, 3600);
                $model->expired_at = date('Y-m-d H:i:s', time() + 3600);
                $model->save();
            }
            array_push($urls, $model->url);
        }

        return $urls;
    }
}
