<?php
$config = [
    'name'   => Yii::t('common', env('WEB_NAME')),
    'homeUrl'=> Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => env('WEB_NAMESPACE'),
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'user' => [
            'class' => 'frontend\modules\user\Module',
            //'shouldBeActivated' => true
        ],
        'api' => [
            'class' => 'frontend\modules\api\Module',
            'modules' => [
                'v1' => 'frontend\modules\api\v1\Module'
            ]
        ]
    ],
    'components' => [
        'view' => [
            'theme' => [
                'basePath' => '@frontend/themes/'.env('THEME'),
                'baseUrl' => '@frontend/themes/'.env('THEME'),
                'pathMap' => [
                    '@frontend/views' => '@app/themes/'.env('THEME'),
                    //'@frontend/views' => '@app/themes/basic',
                    //'@frontend/views' => '@app/themes/edu',
                    //'@frontend/views' => '@app/themes/react',
                ],
            ],
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
        
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'github' => [
                    'class' => 'yii\authclient\clients\GitHub',
                    'clientId' => env('GITHUB_CLIENT_ID'),
                    'clientSecret' => env('GITHUB_CLIENT_SECRET')
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => env('FACEBOOK_CLIENT_ID'),
                    'clientSecret' => env('FACEBOOK_CLIENT_SECRET'),
                    'scope' => 'email,public_profile',
                    'attributeNames' => [
                        'name',
                        'email',
                        'first_name',
                        'last_name',
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => 'common\components\maintenance\Maintenance',
            'enabled' => function ($app) {
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],

        'user' => [
            'class'=>'yii\web\User',
            'identityClass' => 'common\models\User',
            'loginUrl'=>['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'enableSession' => true,
            'as afterLogin' => 'common\behaviors\LoginTimestampBehavior'
        ],
    ],
    'as globalAccess'=>require(__DIR__.'/access.php'),
    'params'=>[
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
                        //'return_url' => 'http://'.$_SERVER['HTTP_HOST'].'/#/coursedetail/',

                        // 本地调试回调地址
                        'return_url' => 'http://app.v1.guangdaxuexiao.com/index.html#/mycourse',
                        // 'return_url' => 'http://192.168.5.119:8082/#/mycourse',

                        //编码格式
                        'charset' => "UTF-8",

                        //签名方式
                        'sign_type'=>"RSA",

                        //支付宝网关
                        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

                        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                        'alipay_public_key' => Yii::getAlias('@common').'/payment/alipay/cert/alipay_public_key.pem',
                        ],
                        'wechatpay' => [
                            // APPID
                            'appid' => 'wxa91bb8c36f5601b5',

                            // 商户号
                            'mch_id' => '1489367612',

                            // 异步回调地址
                            'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/gedu_wechatpay_notify.php',

                            //证书路径https需要
                            // 'sslcertPath' => \Yii::getAlias('@common').'/payment/wechatpay/wechatcert',  

                            //密钥路径https需要
                            // 'sslkeyPath' => \Yii::getAlias('@common').'/payment/wechatpay/wechatcert',  
                            
                            // 货币类型 ISO 4217标准 三位字母代码
                            'fee_type' => 'CNY',  

                            //支付类型 固定为APP
                            'trade_type' => 'APP',

                            // APIkey
                            'apikey' => env('WECHAT_API_KEY'),

                        ],
                ],
                'shuo' => [
                    'alipay' => [
                        'app_id' => "2017092608934297", // 说说说

                        //商户私钥，您的原始格式RSA私钥
                        'merchant_private_key' => Yii::getAlias('@common').'/payment/alipay/cert/shuo_rsa_private_key.pem',

                        //异步通知地址
                        'notify_url' => 'http://'.$_SERVER['HTTP_HOST'].'/shuo_alipay_notify.php',

                        //编码格式
                        'charset' => "UTF-8",

                        //签名方式
                        'sign_type'=>"RSA",

                        // 仅支持JSON
                        'format' => 'JSON',

                        // 该笔订单允许的最晚付款时间，逾期将关闭交易。非必填，默认值15d
                        'timeout_express' => '1m',

                        //销售产品码，商家和支付宝签约的产品码，为固定值
                        'product_code' => 'QUICK_MSECURITY_PAY',

                        //支付宝网关
                        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

                        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
                        'alipay_public_key' => Yii::getAlias('@common').'/payment/alipay/cert/shuo_alipay_public_key.pem',
                    ],
                ],
            ],

    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'=>'yii\gii\Module',
        'generators'=>[
            'crud'=>[
                'class'=>'yii\gii\generators\crud\Generator',
                'messageCategory'=>'frontend'
            ]
        ]
    ];
}

return $config;
