<?php

// 当前项目主配置

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'app_backend',
    'name' => '后台管理系统',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'app_backend\controllers',
    'components' => [
        'mcache' => [
            'class' => 'app_backend\components\MCache',
        ],
        'request' => [
            'cookieValidationKey' => '4wqVfNqSrJlVfEZbHgnul3NneLNbaCgz',
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'backend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [

            ],
        ],
        'assetManager' => [
            'bundles' => false,
        ],
        'db' => $db,
    ],
    'params' => $params,
];

YII_ENV_DEV && require __DIR__ . '/dev.php';

return $config;