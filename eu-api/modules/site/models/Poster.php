<?php

namespace app\modules\site\models;

use Yii;

/**
 * This is the model class for table "posters".
 *
 * @property integer $id
 * @property string $image_url
 * @property integer $image_scale_x
 * @property integer $image_scale_y
 * @property integer $image_pos_x
 * @property integer $image_pos_y
 * @property integer $qr_pos_x
 * @property integer $qr_pos_y
 * @property integer $qr_scale_x
 * @property integer $qr_scale_y
 * @property string $created_at
 * @property string $updated_at
 */
class Poster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_url'], 'required'],
            [['image_scale_x', 'image_scale_y', 'image_pos_x', 'image_pos_y', 'qr_pos_x', 'qr_pos_y', 'qr_scale_x', 'qr_scale_y'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['image_url'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_url' => 'Image Url',
            'image_scale_x' => 'Image Scale X',
            'image_scale_y' => 'Image Scale Y',
            'image_pos_x' => 'Image Pos X',
            'image_pos_y' => 'Image Pos Y',
            'qr_pos_x' => 'Qr Pos X',
            'qr_pos_y' => 'Qr Pos Y',
            'qr_scale_x' => 'Qr Scale X',
            'qr_scale_y' => 'Qr Scale Y',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
