<?php

function isProduction() {
    return $_SERVER['APP_ENV'] === 'production';
}

function isTesting() {
    return $_SERVER['APP_ENV'] === 'testing';
}

function isDevelopment() {
    return !isProduction() && !isTesting();
}

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@api', dirname(dirname(__DIR__)) . './eu-api');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
