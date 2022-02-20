<?php

declare(strict_types=1);

use app\models\User;
use yii\caching\FileCache;
use yii\gii\Module;
use yii\log\FileTarget;
use yii\swiftmailer\Mailer;

$params = require __DIR__.'/params.php';
$db = require __DIR__.'/db.php';

$config = [
    'id' => 'basic',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'basePath' => \dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'video',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],
        'db' => $db,
        'errorHandler' => [
            'errorAction' => 'error/index',
        ],
        'formatter' => [
            'class' => \app\i18n\Formatter::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => Mailer::class,
            'useFileTransport' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'NoJaIIhOvvD48HFC-XTs1uKH1V5NknAQ',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'video/index',
                'video/<slug:[-\w]+>' => 'video/view',
            ],
        ],
        'user' => [
            'identityClass' => User::class,
            'enableAutoLogin' => true,
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => \yii\debug\Module::class,
        'allowedIPs' => [
            '10.0.0.0/8',
            '127.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
            '::1',
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => Module::class,
        'allowedIPs' => [
            '10.0.0.0/8',
            '127.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
            '::1',
        ],
    ];
}

return $config;
