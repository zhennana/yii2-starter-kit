<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl'=> env('LINK_ASSETS'),
    'showScriptName'=>false,
    'rules'=> [
        // Pages
        ['pattern'=>'page/<slug>', 'route'=>'page/view'],

        // Articles

        ['pattern'=>'article/index', 'route'=>'article/index'],
        ['pattern'=>'article/news','route'=>'article/news'],
        ['pattern'=>'article/get-news','route'=>'article/get-news'],
        ['pattern'=>'article/course', 'route'=>'article/course'],
        ['pattern'=>'article/attachment-download', 'route'=>'article/attachment-download'],
        ['pattern'=>'article/about', 'route'=>'article/about'],
        ['pattern'=>'article/merchants', 'route'=>'article/merchants'],
        ['pattern'=>'article/<slug>', 'route'=>'article/view'],
        //['pattern'=>'article/about', 'route'=>'article/about'],
        // Api
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/article', 'only' => ['index', 'view', 'options']],
        ['class' => 'yii\rest\UrlRule', 'controller' => 'api/v1/user', 'only' => ['index', 'view', 'options']]
    ]
];
