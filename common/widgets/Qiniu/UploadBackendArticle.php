<?php

/**
 * @filename 
 * @encoding UTF-8 
 * @author bruce_bnu@126.com
 * @datetime 2015-7-15  18:23:18
 * @version 1.0
 * @Description 七牛上传
  */
namespace common\widgets\Qiniu;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\Widget;
use yii\web\View;

// 加载的哪些静态js
use common\widgets\Qiniu\AssetBackend;

use common\models\FileStorageItem;

class UploadBackendArticle extends Widget
{
    //默认配置
    public $uptoken_url;
    public $upload_url;
    public $article_id;
    public function run()
    {
        $this->registerClientScript();
        if (!Yii::$app->user->id) 
        {
            return '<div>未登录</div>';
        }

        $html = '<div id="container" style="float: right;">
                <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
                    <i class="glyphicon glyphicon-plus"></i>
                    <sapn>选择文件</sapn>
                </a>
            </div>
            <div style="display:none" id="success" class="col-md-12">
            <div class="alert-success">
                队列全部文件处理完毕
            </div>
            </div>
            <div class="col-md-12 ">
            <table class="table table-striped table-hover text-left"   style="margin-top:40px;display:none">
                <thead>
                  <tr>
                    <th class="col-md-4">Filename</th>
                    <th class="col-md-2">Size</th>
                    <th class="col-md-6">Detail</th>
                  </tr>
                </thead>
                <tbody id="fsUploadProgress">
                </tbody>
            </table>
        </div>';
        return $html;
    }
    /**
     * 注册客户端脚本
     */
    protected function registerClientScript()
    {
        //var_dump(\Yii::$app->params); exit();
        $script  = "var uptoken_url = '".$this->uptoken_url."';";
        $script .= "var qiniu_domain ='".\Yii::$app->params['qiniu']['wakooedu']['domain'].'/'."';";
        $script .= "var upload_url='".$this->upload_url."'";
        $this->view->registerJs($script, View::POS_BEGIN);
        AssetBackend::register($this->view);

    }
}