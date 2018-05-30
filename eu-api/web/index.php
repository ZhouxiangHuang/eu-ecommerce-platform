<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
if($_SERVER['HOSTNAME'] == 'iZbp1eqd6o5lpshtjys8c9Z') {
    defined('YII_ENV') or define('YII_ENV', 'test');
} else {
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@api', dirname(dirname(__DIR__)) . './eu-api');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
