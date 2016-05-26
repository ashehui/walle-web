<?php
$config = [
    'id' => 'basic',
    'timeZone'   => 'Asia/Shanghai',
    'basePath'   => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'controllerNamespace' => 'app\controllers',
    'defaultRoute'        => 'task/index',
    'components' => [
		'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.31.253.207;dbname=deploy',
            'username' => 'admin',
            'password' => 'Yhhwd3306!@#$%',
            'charset' => 'utf8'
        ],
        'session' => [
            'class'        => 'yii\web\DbSession',
            'db'           => 'db',
            'sessionTable' => 'session',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class'      => 'Swift_SmtpTransport',
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => ['service@humanshu.com' => '花满树出品']
            ],
        ],
        'log'  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'user' => [
            'identityClass'   => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'bootstrap'  => [
        'app\components\EventBootstrap',
        'log',
    ],
    'params'     => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
    ];
}

return $config;
