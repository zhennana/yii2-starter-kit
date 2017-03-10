<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */

//\common\assets\React::register($this);

namespace common\assets;

use yii\web\AssetBundle;

class React extends AssetBundle
{
    public $sourcePath = '@bower/react';
    public $js = [
    /*
    (YII_ENV == 'dev') ? 'react.js' : 'react.min.js',
    (YII_ENV == 'dev') ? 'react-dom.js' :'react-dom.min.js'
    */
        'react.js',
        //'react-with-addons.min.js',
        'react-dom.min.js',

    ];

    public $jsOptions = [
        // always put this in the head because we need it before page is loaded
        'position' => \yii\web\View::POS_HEAD
    ];
    public $css = [
        //'css/AdminLTE.min.css',
        //'css/skins/_all-skins.min.css'
    ];
    public $depends = [
        //'opw\react\JSXTransformerAsset', // optional
        //'opw\react\ReactAsset'
        //'yii\web\JqueryAsset',
        //'yii\jui\JuiAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
        //'common\assets\FontAwesome',
        //'common\assets\JquerySlimScroll'
    ];
}
