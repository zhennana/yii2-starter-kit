<?php
return [
    'class'=>'yii\web\UrlManager',
    'enablePrettyUrl' => env('LINK_ASSETS_BACKEND'), //env('LINK_ASSETS'),
    'showScriptName' => false,
    'rules'=>[
        // url rules
        ['pattern'=>'site/doc', 'route'=>'site/doc'],
       //['pattern'=>'users/config/init','route'=>'users/config/init']
    ]
];
