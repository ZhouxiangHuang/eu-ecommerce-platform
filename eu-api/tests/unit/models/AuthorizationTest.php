<?php
/**
 * Created by PhpStorm.
 * User: Zhouxiang
 * Date: 2018/7/27
 * Time: 下午1:29
 */

namespace tests\models;


use app\modules\site\models\MerchantAuthorization;
use app\modules\site\models\Merchants;
use app\modules\site\models\VerificationCodes;

class AuthorizationTest extends \Codeception\Test\Unit
{
    private $merchantId = 1;

    protected function _before()
    {
        VerificationCodes::deleteAll();
        MerchantAuthorization::deleteAll();
    }

    public function testCodeGenerate() {
        $merchant = Merchants::findOne(['id' => $this->merchantId]);
        VerificationCodes::generate($merchant->user_id);
        $count = VerificationCodes::find()
            ->where(['user_id' => $merchant->user_id])
            ->count();

        expect($count)->notEquals(0);
    }

    public function testCodeVerification() {
        $merchant = Merchants::findOne(['id' => $this->merchantId]);
        $code = $merchant->getVerCode();
        expect(VerificationCodes::isValid($merchant->user_id, $code))->equals(true);
        expect(VerificationCodes::isValid(123, $code))->equals(false);
        expect(VerificationCodes::isValid($merchant->user_id, 111111))->equals(false);
    }

    public function testAuthorization() {
        $merchant = Merchants::findOne(['id' => $this->merchantId]);
        $isAuthorized = $merchant->isAuthorized($merchant->user_id, Merchants::AUTH_TYPE_PRICE);
        expect($isAuthorized)->equals(false);
        $merchant->authorize($merchant->user_id, Merchants::AUTH_TYPE_PRICE);
        $isAuthorized = $merchant->isAuthorized($merchant->user_id, Merchants::AUTH_TYPE_PRICE);
        expect($isAuthorized)->equals(true);
    }
}