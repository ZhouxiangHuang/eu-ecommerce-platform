<?php

$rules = [
    'authorization' => [
        'guest' => 'app\modules\site\Module',
        'customer' => 'app\modules\site\Module',
        'merchant' => 'app\modules\site\Module',
    ]
];

return $rules;
