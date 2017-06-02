<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
	'timezone' => 'Asia/ShangHai',
    'bootstrap' => ['log'],
	// 设置目标语言为英语
    'language' => 'en-us',
    // 设置源语言为英语
    'sourceLanguage' => 'zh-cn',
	'modules'=>[
		'admin'=>[
			'class'=>'app\modules\admin\admin',	
			'defaultRoute'=>'index/index',
		],	
        'api'=>[
            'class'=>'app\modules\api\api',
            'defaultRoute'=>'index/index',
        ],
	],
		
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DnGDCrCv3YrGIOZS7b_TLgfqOugmT3gs',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        	'enableSession' => true
        ],
    		
    	'admin' => [
    		'class' => '\yii\web\User',
    		'identityClass' => 'app\modules\admin\models\Admin',
    		'identityCookie' => ['name' => '__admin_identity', 'httpOnly' => true],
   			'enableAutoLogin' => true,
  			'enableSession' => true,
    		'idParam' => '__admin',
  			'loginUrl' => ['/admin/login/login'],
    	],
    	
    		
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
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//         	'suffix' => '.html',
            'rules' => [
            	
            ],
        ],
    		
    	'i18n' => [
    		'translations' => [
    			'app*' => [
    				'class' => 'yii\i18n\PhpMessageSource',
    					'basePath' => '@app/messages',
    					'sourceLanguage' => 'zh-CN',
    					'fileMap' => [
	    					'app' => 'app.php',
// 	    					'app/error' => 'error.php',
    					],
    			],
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
