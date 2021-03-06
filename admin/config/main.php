<?php
use common\models\User;
use vcms\behaviors\GlobalAccessBehavior;

$params = array_merge(
    require(__DIR__ . '/../../cms/common/config/params.php'),
    require(__DIR__ . '/../../cms/common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(dirname(__DIR__)) . '/cms/backend',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/index'
            ],
        ],
    ],
    'as globalAccess' => [
        'class' => GlobalAccessBehavior::className(),
        'rules' => [
            [
                'controllers' => ['gii/default'],
                'allow' => true,
                'roles' => [User::ROLE_SUPER_ADMIN],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['login'],
                'roles' => ['?'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['logout'],
                'roles' => ['@'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'actions' => ['error'],
                'roles' => ['?', '@'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['accessBackend'],
            ],
            [
                'controllers' => ['member'],
                'allow' => true,
                'roles' => [User::ROLE_ADMIN],
            ],
        ],
    ],
    'params' => $params,
];
