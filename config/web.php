<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation' => !YII_DEBUG,
            'admins' => ['Alex'],
            'modelMap' => [
                'LoginForm' => 'app\modules\user\models\LoginForm',
                'Profile' => 'app\modules\user\models\Profile',
                'RegistrationForm' => 'app\modules\user\models\RegistrationForm',
                'SettingsForm' => 'app\modules\user\models\SettingsForm',
                'Transactions' => 'app\modules\user\models\Transactions',
                'User' => 'app\modules\user\models\User',
                'UserSearch' => 'app\modules\user\models\UserSearch',
            ],
            'controllerMap' => [
                'recovery' => 'app\modules\user\controllers\RecoveryController',
                'registration' => 'app\modules\user\controllers\RegistrationController',
                'security' => 'app\modules\user\controllers\SecurityController',
                'settings' => 'app\modules\user\controllers\SettingsController',
                'transactions' => 'app\modules\user\controllers\TransactionsController',
            ],
        ],
    ],
    //'defaultRoute' => 'user',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
       /*     'showScriptName' => false,
            'enableStrictParsing' => false,*/
            'rules' => [
                'user' => 'user/security/login',
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/modules/user/views'
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '15TFLfxI4s8o7KB_Ud_KeLdI7BUzeQeE',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /*'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
