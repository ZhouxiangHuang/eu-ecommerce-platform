<?php
//个人测试
//ACCESS_ID
//
//
//define('OSS_ACCESS_ID', "w78egZebqUXn7cJp");
//
////ACCESS_KEY
//define('OSS_ACCESS_KEY', "59x0hA0juNJ3F2KcYHWpfiPu0f8lwS");
////define('OSS_ACCESS_ID', "Iyu1ivzJ97aP64Dm");
////
//////ACCESS_KEY
////define('OSS_ACCESS_KEY', "SiGY0fnrQGb32TxBrKaV7DKqzWMLUw");
//
//
////是否记录日志
//define('ALI_LOG', FALSE);
//
////自定义日志路径，如果没有设置，则使用系统默认路径，在./logs/
//define('ALI_LOG_PATH', __DIR__ . "/logs");
//
////是否显示LOG输出
//define('ALI_DISPLAY_LOG', FALSE);
//
////语言版本设置
//define('ALI_LANG', 'zh');

/** @var Module $module */
use yii\gii\Module;

$app = Yii::$app;
$accessId = $app->params['oss']['access_id'];
$accessKey = $app->params['oss']['key'];

define('OSS_ACCESS_ID', $accessId);

//ACCESS_KEY
define('OSS_ACCESS_KEY', $accessKey);

//是否记录日志
define('ALI_LOG', FALSE);

//自定义日志路径，如果没有设置，则使用系统默认路径，在./logs/
if(!defined('ALI_LOG_PATH')) {
    $path = '/tmp/app.log';
    define('ALI_LOG_PATH', $path);
}

//是否显示LOG输出
define('ALI_DISPLAY_LOG', FALSE);

//语言版本设置
define('ALI_LANG', 'zh');



