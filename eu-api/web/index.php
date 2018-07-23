<?php

$env = defined('APP_ENV') || 'development';
require __DIR__ . '/../vendor/autoload.php';


// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@api', dirname(dirname(__DIR__)) . './eu-api');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
