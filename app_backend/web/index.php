<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../../vendor/vendor/autoload.php';
require __DIR__ . '/../../vendor/vendor/yiisoft/yii2/Yii.php';

// 加载公用项目别名配置
require __DIR__ . '/../../common/config/bootstrap.php';

// 加载当前项目别名配置
require __DIR__ . '/../config/bootstrap.php';

// 加载当前项目配置
$config = yii\helpers\ArrayHelper::merge
(
    require __DIR__ . '/../../common/config/main.php',
    require __DIR__ . '/../config/main.php'
);

(new yii\web\Application($config))->run();