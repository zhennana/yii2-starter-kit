<?php

/**
 * @filename Assets.php 
 * @encoding UTF-8 
 * @author kangsa@126.com
 * @datetime 2015-7-15  18:26:32
 * @version 1.0
 * @Description
  */
namespace common\widgets\Qiniu;
use yii\web\AssetBundle;
class AssetShareStream extends AssetBundle
{
    public $js = [
          'js/plupload/plupload.full.min.js',
          'js/plupload/i18n/zh_CN.js',
          'js/ui.js',
          'js/qiniu.js',
          'js/highlight/highlight.js',
          'js/main-share.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public function init()
    {
        $this->sourcePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
    }
}