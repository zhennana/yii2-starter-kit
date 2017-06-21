<?php
/** 权限验证笔记
 * yii\filters\AccessRule::roles: 
 *      ? 匹配未验证用户，来宾
 *      @ 匹配身份验证用户
 * yii\filters\AccessRule::ips 匹配'192.168.*'
 * yii\filters\AccessRule::verbs: 指定请求方法。例如GET、POST
 *
 * Yii::$app->authManager
 **/
if (env('THEME') == 'happy') {
    return [
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
           [
                'controllers'=>['user/sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['user/sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?','@'],
                'actions'=>['set-locale']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['index','error']
            ],
            [
                'controllers'=>['article'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['course','view']
            ],
            [
                'controllers'=>['page'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['view']
            ],
            [
                'controllers'=>['user/default'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['index','avatar-upload']
            ],
        ]
    ];
}
return [
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
           [
                'controllers'=>['user/sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['user/sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site','article'],
                'allow' => true,
                'roles' => ['?','@'],
            ],
            [
                'controllers'=>['page'],
                'allow' => true,
                'roles' => ['?','@'],
            ],
            [
                'controllers'=>['user/default'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['index','avatar-upload']
            ],
        ]
    ];