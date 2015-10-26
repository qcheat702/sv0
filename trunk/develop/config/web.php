<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    // 默认路由
    'defaultRoute'=>'article',
    'language' => 'zh-CN',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    'aliases'=>[
        //全局组件别名
        '@sv/components'  => '@app/components',
        '@sv/widgets'  => '@app/widgets',
    ], 
  
    'components' => [
        'request' => [
            'cookieValidationKey' => 'd87fasd78fa',
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
            'class' => 'yii\swiftmailer\Mailer',
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
                //URL地址管理
        'urlManager' => [
            // 'enablePrettyUrl' => true,
            // 'showScriptName' => false,
        ],
        
        'authManager' => [  
            'class' => 'yii\rbac\DbManager',
        ],

    ],
    'params' => $params,
];


/**
 * 系统资源重定向
 */
$config['components']['assetManager']['bundles'] = [
    'yii\web\JqueryAsset' => [
        'sourcePath' => null,
        'baseUrl' => $config['params']['defaultAssetUrl'],
        // 'baseUrl' => '@assetPath',
        'js'=>['lib/jquery1.11.3/jquery.min.js'],
    ],
    'yii\bootstrap\BootstrapAsset' => [
        'sourcePath' => null,
        'baseUrl' => $config['params']['defaultAssetUrl'],
        'css'=>['lib/bootstrap-3.3.5-dist/css/bootstrap.min.css']
    ],
    'yii\bootstrap\BootstrapPluginAsset' => [
        'sourcePath' => null,
        'baseUrl' => $config['params']['defaultAssetUrl'],
        'js'=>['lib/bootstrap-3.3.5-dist/js/bootstrap.min.js']
    ],
    // 'app\assets\AppAsset' => [
    //     'baseUrl' => $config['params']['assetUrl'],
    // ],
];


/**
 * 加载模块
 */
// 加载文章模块
$config['aliases']['@sv/article']  = '@app/modules/article';
$config['modules']['article']    = [
    'class' => 'sv\article\Module',
    'assetUrl' =>  $config['params']['assetUrl']
    ];
// 加载管理模块
$config['aliases']['@sv/admin']  = '@app/modules/admin';
$config['modules']['admin']      = [  
    'class' => 'sv\admin\Module',  
    'assetUrl' => $config['params']['defaultAssetUrl']
    ];
// 加载会员模块
$config['modules']['member']     = ['class' => 'app\modules\member\Module'];
// 加载网店模块
$config['modules']['shop']       = ['class' => 'app\modules\shop\Module'];
// RBAC模块  
$config['aliases']['@mdm/admin'] = '@app/modules/yii2-admin-2.0.0';
$config['modules']['rbac']       = [
                                        'class' => 'mdm\admin\Module',
                                        'layout' => 'left-menu',
                                        'mainLayout' => '@sv/admin/views/layouts/main.php',
                                        'controllerMap' => [
                                             'assignment' => [
                                                'class' => 'mdm\admin\controllers\AssignmentController',
                                                'userClassName' => $config['components']['user']['identityClass'], 
                                                // 'userClassName' => 'app\models\User', 
                                                'idField' => 'uid',
                                                'usernameField' => 'username',
                                                // 'searchClass' => 'app\models\UserSearch'
                                            ]
                                        ],
                                    ];


//开发模式配置项
if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
