<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'c2chkRfznxnm58gOfC-qGJajM7WpIOaz',
            'parsers' => [
                'application/json' => \yii\web\JsonParser::class,
                'multipart/form-data' => \yii\web\MultipartFormDataParser::class,
            ]
        ],
        'response' => [
//            'format' => \yii\web\Response::FORMAT_JSON
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
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
//                autenticação
                'api/v1/auth/login' => 'api/v1/auth/login',
//                validando endpoints comuns de todas as entidades
//            validando endpoit de cadastro
                'POST api/v1/<controller:[\w-]+>/new' => 'api/v1/entity/create',
                'PUT api/v1/<controller:[\w-]+>/<id:[.]+>' => 'api/v1/entity/update',
                'DELETE api/v1/<controller:[\w-]+>/<id:[.]+>' => 'api/v1/entity/delete',
                'GET api/v1/<controller:[\w-]+>' => 'api/v1/entity/list',
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
