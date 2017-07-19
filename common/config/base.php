<?php
date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
$config = [
    'name'=>'瓦酷机器人',
    'vendorPath'=>dirname(dirname(__DIR__)).'/vendor',
    'extensions' => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage'=>'en-US',
    'language'=>'zh-CN', // en-US 
    'bootstrap' => ['log'],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => '{{%rbac_auth_item}}',
            'itemChildTable' => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable' => '{{%rbac_auth_rule}}',
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@common/runtime/cache'
        ],

        'commandBus' => [
            'class' => 'trntv\bus\CommandBus',
            'middlewares' => [
                [
                    'class' => '\trntv\bus\middlewares\BackgroundCommandMiddleware',
                    'backgroundHandlerPath' => '@console/yii',
                    'backgroundHandlerRoute' => 'command-bus/handle',
                ]
            ]
        ],

        'formatter'=>[
            'class'=>'yii\i18n\Formatter',
            'thousandSeparator' => '.',
            'decimalSeparator' => ',',
            'currencyCode' => '$',
        ],

        'glide' => [
            'class' => 'trntv\glide\components\Glide',
            'sourcePath' => '@storage/web/source',
            'cachePath' => '@storage/cache',
            'urlManager' => 'urlManagerStorage',
            'maxImageSize' => env('GLIDE_MAX_IMAGE_SIZE'),
            'signKey' => env('GLIDE_SIGN_KEY')
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            //'useFileTransport' => true,
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => env('ADMIN_EMAIL')
            ]
        ],

        'db'=>[
            'class'=>'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'campus'=>[
                'class'=>'yii\db\Connection',
                'dsn' => env('DB_DSN_CAMPUS'),
                'username' => env('DB_USERNAME_CAMPUS'),
                'password' => env('DB_PASSWORD_CAMPUS'),
                'tablePrefix' => env('DB_TABLE_PREFIX_CAMPUS'),
                'charset' => 'utf8',
                'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'db'=>[
                    'class' => 'yii\log\DbTarget',
                    //'levels' => ['error', 'warning', 'info','trace','profile'], // test
                    'levels' => ['error', 'warning'],

                    //除了except对应的分类之外，其他异常日志都记录
                    'except'=>['yii\web\HttpException:*', 'yii\i18n\I18N\*'], 
                    'prefix'=>function () {
                        $logged_ip = !Yii::$app->getRequest()->getUserIP() ? '' : Yii::$app->getRequest()->getUserIP();
                        $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id : 0;
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;

                        return sprintf(
                            '[%s] [IP: %s] [user_id: %s] [%s]', 
                            Yii::$app->id, $logged_ip, $user_id, $url
                        );
                    },
                    'logVars'=>['_SERVER'],
                    'logTable'=>'{{%system_log}}',
                ],
                //在原配置的基础上，增加以下配置（新增一个FileTarget）
                //Yii::info(join(" ",$data), 'users\isguest');
                //Yii::info(join(" ",$data), 'users\behavior');
                'users_FileTarget' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace','profile'],
                    'logVars'=>[],
                    //表示以yii\db\或者app\models\开头的分类都会写入这个文件
                    'categories'=>['users\*'],
                    //表示写入到文件sql.log中
                    //'logFile'=>'@runtime/logs/users_behavior.log',
                    'logFile' => '@runtime/logs/users_behavior.log',
                    'maxFileSize'=> 1024, //Maximum log file size, in kilo-bytes. Defaults to 10240, meaning 10MB.
                    'maxLogFiles'=> 10,
                ],
                // 微信API
                // Yii::info(json_encode($info), 'wechat\path');
                'wechat_FileTarget' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace','profile'],
                    'logVars'=>[],
                    //表示以yii\db\或者app\models\开头的分类都会写入这个文件
                    'categories'=>['wechat\*'],
                    //表示写入到文件sql.log中
                    //'logFile'=>'@runtime/logs/users_behavior.log',
                    'logFile' => '@runtime/wechat_api_log/info.log',
                    'maxFileSize'=> 1024, //Maximum log file size, in kilo-bytes. Defaults to 10240, meaning 10MB.
                    'maxLogFiles'=> 10,
                ],

                // online debug
                // Yii::info(json_encode($info), 'debug\exception');
                'debug_FileTarget' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace','profile'],
                    'logVars'=>[],
                    //表示以yii\db\或者app\models\开头的分类都会写入这个文件
                    'categories'=>['debug\*'],
                    //表示写入到文件sql.log中
                    //'logFile'=>'@runtime/logs/users_behavior.log',
                    'logFile' => '@runtime/online_debug/info.log',
                    'maxFileSize'=> 1024, //Maximum log file size, in kilo-bytes. Defaults to 10240, meaning 10MB.
                    'maxLogFiles'=> 10,
                ],

                // online payment
                // Yii::info(json_encode($info), 'payment\exception');
                'payment_FileTarget' => [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning','info','trace','profile'],
                    'logVars'=>[],
                    //表示以yii\db\或者app\models\开头的分类都会写入这个文件
                    'categories'=>['payment\*'],
                    //表示写入到文件sql.log中
                    //'logFile'=>'@runtime/logs/users_behavior.log',
                    'logFile' => '@runtime/payment/info.log',
                    'maxFileSize'=> 1024, //Maximum log file size, in kilo-bytes. Defaults to 10240, meaning 10MB.
                    'maxLogFiles'=> 10,
                ],
            ],
        ],

        'i18n' => [
            'translations' => [
                'app'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                ],
                '*'=> [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath'=>'@common/messages',
                    'fileMap'=>[
                        'common'=>'common.php',
                        'backend'=>'backend.php',
                        'frontend'=>'frontend.php',
                    ],
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
                /* Uncomment this code to use DbMessageSource
                 '*'=> [
                    'class' => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable'=>'{{%i18n_source_message}}',
                    'messageTable'=>'{{%i18n_message}}',
                    'enableCaching' => YII_ENV_DEV,
                    'cachingDuration' => 3600,
                    'on missingTranslation' => ['\backend\modules\i18n\Module', 'missingTranslation']
                ],
                */
            ],
        ],

        'fileStorage' => [
            'class' => '\trntv\filekit\Storage',
            'baseUrl' => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path' => '@storage/web/source'
            ],
            'as log' => [
                'class' => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],

        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],

        'urlManagerBackend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@backendUrl')
            ],
            require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        // Yii::$app->urlManagerFrontend->createUrl(["post/view","id"=>$post->i‌​d])
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo' => Yii::getAlias('@frontendUrl')
            ],
            require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage' => \yii\helpers\ArrayHelper::merge(
            [
                'hostInfo'=>Yii::getAlias('@storageUrl')
            ],
            require(Yii::getAlias('@storage/config/_urlManager.php'))
        )
    ],
    //Yii::$app->params['image']['image_original_size'];
    //Yii::$app->params['image']['image_shrinkage_size'];
    'params' => [
        'user_avatar'=>'http://static.v1.wakooedu.com/o_1bf6nmv571qb6rva18c1c4r1kjq9.png',
        'qiniu'=>[
            'wakooedu'=>[
                'access_key'=>env('QINIU_ACCESS_KEY'),
                'secret_key'=>env('QINIU_SECRET_KEY'),
                'domain' => env('QINIU_DOMAIN'),
                'bucket' => env('QINIU_BUCKET')
            ]
        ],
        //裁剪图片大小参数
        'image'=>[
            'image_original_size'=>"?imageView2/3/w/600/h/600",
            'image_shrinkage_size'=>"?imageView2/1/w/400/h/400",
        ],
        'adminEmail' => env('ADMIN_EMAIL'),
        'robotEmail' => env('ROBOT_EMAIL'),
        'availableLocales'=>[
        // For example, the ID en-US stands for the locale of "English and the United States".
            'en-US'=>'English (US)',
            // 'ru-RU'=>'Русский (РФ)',
            //'uk-UA'=>'Українська (Україна)',
            //'es-ES' => 'Español',
            //'es' => 'Español',
            //'vi' => 'Tiếng Việt',
            'zh-CN' => '简体中文',
            //'pl-PL' => 'Polski (PL)',
        ],
        // defines codes for the names of countries, https://zh.wikipedia.org/wiki/ISO_3166-1
        // Currency code, https://zh.wikipedia.org/wiki/ISO_4217
        /*
            'USD' => '美元',
            'GBP' => '英镑',
            'EUR' => '欧元',
            'CNY' => '人民币',
            'JPY' => '日元',
            'AUD' => '澳元',
            'HKD' => '港元',
            'KRW' => '韩圆',
            'PHP' => '菲律宾披索',
        */
        'payment' => [
            'gedu' => [
                'alipay' => [
                //应用ID,您的APPID。
                'app_id' => "2017071107712808", // 光大

                //商户私钥，您的原始格式RSA私钥
                'merchant_private_key' => Yii::getAlias('@common').'/payment/alipay/cert/gedu_rsa_private_key.pem',

                //异步通知地址
                'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/gedu_alipay_notify.php',

                //同步跳转,尾部需要拼接主课件ID
                'return_url' => 'http://'.$_SERVER['HTTP_HOST'].'/#/coursedetail/',

                //编码格式
                'charset' => "UTF-8",

                //签名方式
                'sign_type'=>"RSA",

                //支付宝网关
                'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

                //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                'alipay_public_key' => Yii::getAlias('@common').'/payment/alipay/cert/alipay_public_key.pem',
                ],
            ],
        ],

    ], // component 结束
    
    // Yii::$app->params['something']
    // 'params' => require(__DIR__.'/params.php'),

];

if (YII_ENV_PROD) {
    $config['components']['log']['targets']['email'] = [
        'class' => 'yii\log\EmailTarget',
        'except' => ['yii\web\HttpException:*'],
        'levels' => ['error', 'warning'],
        'message' => ['from' => env('ROBOT_EMAIL'), 'to' => env('ADMIN_EMAIL')]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module'
    ];

    $config['components']['cache'] = [
        'class' => 'yii\caching\DummyCache'
    ];
    $config['components']['mailer']['transport'] = [
        'class' => 'Swift_SmtpTransport',
        'host' => env('SMTP_HOST'),
        'port' => env('SMTP_PORT'),
    ];
}

return $config;
