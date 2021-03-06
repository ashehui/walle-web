<?php
$config = [
    'id' => 'basic',
    'name' => '代码发布系统',
    'timeZone'   => 'Asia/Shanghai',
    'basePath'   => dirname(__DIR__),
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'controllerNamespace' => 'app\controllers',
    'defaultRoute'        => 'task/index',
    'components' => [
		'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=walle',
            'username' => 'root',
            'password' => '880816',
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
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/adminlte'
                ],  
            ],  
        ],  
        'assetManager' => [
            'appendTimestamp' => false,
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-blue',
                    //'skin' => 'skin-black',
                    //'skin' => 'skin-red',
                    //'skin' => 'skin-yellow',
                    //'skin' => 'skin-purple',
                    //'skin' => 'skin-green',
                    //'skin' => 'skin-blue-light',
                    //'skin' => 'skin-black-light',
                    //'skin' => 'skin-red-light',
                    //'skin' => 'skin-yellow-light',
                    //'skin' => 'skin-purple-light',
                    //'skin' => 'skin-green-light',
                ],  
            ]   
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
