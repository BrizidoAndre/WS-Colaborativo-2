<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'TiAhneudZLq3j5_k8vMKQQ-7KqXMhBCB',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'format' => \yii\web\Response::FORMAT_JSON
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'cors' => [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin' => [
                    '*',
                ],
                'Access-Control-Request-Method' => [
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                    'HEAD',
                    'OPTIONS',
                ],
                'Access-Control-Request-Headers' => [
                    '*',
                ],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ]
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableSession'   => false,   // <- DESLIGAR SESSÕES
            'loginUrl'        => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'api/v1/posts/create' => 'api/v1/posts/create',
                'api/v1/posts/mine' => 'api/v1/posts/mine',
                'api/v1/posts/search' => 'api/v1/posts/search',
                'api/v1/posts/<id>' => 'api/v1/posts/single',
                'api/v1/comments/create/<id>' => 'api/v1/comments/create',
                'api/v1/comments/vote/<id>' => 'api/v1/comments/vote',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
