<?php

// 公用项目数据库配置
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=192.168.101.245;dbname=mostop_free',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
    'tablePrefix' => 'mostop_',
    'enableSchemaCache' => false,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];