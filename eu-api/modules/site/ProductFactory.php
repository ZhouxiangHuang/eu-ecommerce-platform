<?php
/**
 * Created by PhpStorm.
 * User: bc
 * Date: 2018/5/1
 * Time: 下午9:40
 */

namespace app\modules\site;


use app\common\DataSource;
use app\helpers\Oss;
use app\modules\site\interfaces\ProductFactoryInterface;
use app\modules\site\models\ProductImages;
use app\modules\site\models\Products;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class ProductFactory implements ProductFactoryInterface
{
    static function create($form)
    {
        $imageOnly = ArrayHelper::getValue($form, 'image_only');
        $fileName = ArrayHelper::getValue($form, 'file_name');
        $dataSource = new DataSource();
        $isSuccess = $dataSource->storeImage($fileName);

        $merchantId = 1;
        if($isSuccess) {
            if(!$imageOnly) {
                $product = new Products();
                $product->type = ArrayHelper::getValue($form, 'type');
                $product->merchant_id = $merchantId;
                $product->product_unique_code = ArrayHelper::getValue($form, 'code');
                $product->price = ArrayHelper::getValue($form, 'price');
                $product->hot_item = ArrayHelper::getValue($form, 'hot');
                $product->description = ArrayHelper::getValue($form, 'description');
                $product->status = 1;
                $product->save();

                if($product->errors) {
                    Yii::error($product->errors);
                } else {
                    return true;
                }
            }
        }
    }

}