<?php

declare(strict_types=1);

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => "pgsql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}",
    'username' => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset' => 'utf8',
    'enableSchemaCache' => YII_ENV_PROD,
    'schemaCacheDuration' => YII_ENV_PROD ? 86400 : 0,
];
