<?php

namespace app\modules\site\models;

use app\helpers\Oss;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "merchants".
 *
 * @property int $id
 * @property int $user_id 用户
 * @property string $store_name 商户名
 * @property string $open_at 开店时间
 * @property string $closed_at 关店时间
 * @property string $country 国家
 * @property int $currency_id 货币单位
 * @property string $city 城市
 * @property string $address 地址
 * @property string $mobile 联系电话
 * @property string $status 状态
 * @property string $announcement 公告
 * @property string $profile_img_name OSS图片名
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 */
class Merchants extends \yii\db\ActiveRecord
{
    const LIST_SIZE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'merchants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_name'], 'required'],
            [['open_at', 'closed_at', 'created_at', 'updated_at'], 'safe'],
            [['store_name'], 'string', 'max' => 20],
            [['address', 'announcement'], 'string', 'max' => 50],
            [['mobile'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_name' => 'Store Name',
            'open_at' => 'Open At',
            'closed_at' => 'Closed At',
            'country' => 'Country',
            'city' => 'City',
            'address' => 'Address',
            'mobile' => 'Mobile',
            'announcement' => 'Announcement',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static function register($userId, $storeName, $address, $mobile) {
        $merchant = new Merchants();
        $merchant->user_id = $userId;
        $merchant->store_name = $storeName;
        $merchant->address = $address;
        $merchant->mobile = $mobile;
        $merchant->status = 1;
        $merchant->save();
        if($merchant->errors) {
            Yii::error($merchant->errors);
            return false;
        }
        return true;
    }

    static function all($offset = 0, $country, $category) {
        $queries = ['status' => 1];

        if($country) {
            $queries['country'] = $country;
        }

        if($category) {
            $tagIds = MerchantsTags::findChildrenTags($category); //通过父类找出所有子类
            $merchantIdsModel = MerchantsTags::find()->where(['tag_id' => $tagIds])->select('merchant_id')->all();
            $ids = [];
            /** @var MerchantsTags $model */
            foreach ($merchantIdsModel as $model) {
                array_push($ids, $model->merchant_id);
            }
            $queries['id'] = $ids;
        }

        $merchants = Merchants::find()
            ->where($queries)
            ->offset($offset * Merchants::LIST_SIZE)
            ->limit(Merchants::LIST_SIZE)
            ->all();

        $result = [];
        /** @var Merchants $merchant */
        foreach ($merchants as $merchant) {
            $tags = MerchantsTags::getAllTags($merchant->id);

            $merchantFormatted = [];
            $merchantFormatted['id'] = $merchant->id;
            $merchantFormatted['name'] = $merchant->store_name;
            $merchantFormatted['address'] = $merchant->address;
            $merchantFormatted['announcement'] = $merchant->announcement;
            $merchantFormatted['tags'] = $tags;
            $merchantFormatted['imageUrl'] = $merchant->getProfile();
            $merchantFormatted['productImages'] = $merchant->getProductPeeks();
            $merchantFormatted['country'] = $merchant->country;
            $result[] = $merchantFormatted;
        }

        return $result;
    }

    static function registeredCountries() {
        $merchants = Merchants::find()->where('id > 0')->groupBy('country')->select('country')->all();

        $array = [];
        /** @var Merchants $merchant */
        foreach ($merchants as $merchant) {
            $countryCode = $merchant->country;
            $country = Countries::findOne(['country_code' => $countryCode]);
            if($country) {
                $name = $country->name;
                array_push($array, ['code' => $countryCode, 'name' => $name]);
            }
        }

        return $array;
    }

    public function addProfile($fileName) {
        $ext = pathinfo($_FILES[$fileName]['name'], PATHINFO_EXTENSION);
        $dateTime = time() . rand(111, 999);
        $name = 'wx_' . $dateTime . '.' . $ext;

        $uploadedFile = UploadedFile::getInstanceByName($fileName);
        $uploadedFile->saveAs($path = '/tmp/' . $name);

        $oss = new Oss();
        $isSuccess = $oss->putObject($name, $path);

        if($isSuccess) {
            unlink($path);
            $this->profile_img_name = $name;
            $this->save();
            if($this->errors) {
                Yii::error($this->errors);
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function getProfile() {
        $oss = new Oss();
        $url = $oss->getUrl($this->profile_img_name, 7200);

        return $url ? $url : null;
    }

    public function getProductPeeks() {
        $products = Products::find()->where(['merchant_id' => $this->id])->andWhere(['hot_item' => 1])->andWhere(['status' => 1])->limit(3)->all();

        $images = [];
        /** @var Products $product */
        foreach ($products as $product) {
            $image = $product->getImages(1);
            $images = array_merge($images, $image);
        }

        if(count($products) < 3) {
            for($i = 0; $i < 3 - count($products); $i ++) {
                $images[] = ['url' => '/images/no-image-sm.png'];
            }
        }

        return $images;
    }

    public function getCurrency() {
        $currencyModel = Currency::findOne(['id' => $this->currency_id]);
        return $currencyModel->symbol;
    }
}
