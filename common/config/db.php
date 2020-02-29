<?php

// 公用项目数据库配置
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=192.168.101.201;dbname=mostop_free', // TODO
    'username' => 'root',  // TODO
    'password' => '123456',  // TODO
    'charset' => 'utf8',
    'tablePrefix' => 'mostop_',
    'enableSchemaCache' => false, // TODO
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];