<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$modules = [
    'site' => [
        'class' => 'app\modules\site\Module'
    ]
];

return $modules;
