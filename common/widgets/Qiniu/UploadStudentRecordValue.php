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
use common\widgets\Qiniu\AssetStudentRecordValue;
//use backend\modules\campus\models\


class UploadStudentRecordValue extends Widget
{
    //默认配置
    public $uptoken_url;
    public $upload_url;
    public $zone_url ;
    public $keys = 4;
    public function run()
    {
        $this->registerClientScript();
        if (!Yii::$app->user->id) 
        {
            return '<div>未登录</div>';
        }
        // $html = Html::dropDownList(
        //     'status',
        //     null,
        //     Storage::$status,
        //     ['id'=>'status','class'=>'form-control col-xs-5']
        // );
        $html = '';
        $html .= '<div id="container" style="float: left;">
                <a class="btn btn-default btn-lg " id="pickfiles" href="#" >
                    <i class="glyphicon glyphicon-plus"></i>
                    <sapn>上传图片</sapn>
                </a>
            </div>
            <div style="display:none" id="success" class="col-md-12">
            </div>
            <div class="col-md-12 ">
            <table class="table table-striped table-hover text-left"   style="margin-top:40px;display:none">
                <thead>
                  <tr>
                    <th class="col-md-4">文件名</th>
                    <th class="col-md-2">文件大小</th>
                    <th class="col-md-6">详情</th>
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
        $this->zone_url = \Yii::$app->params['qiniu']['wakooedu']['zone_url'];
        // if($this->zone_url != false){
        //     $script .= "var zone_url = '".$this->zone_url."';";
        // }
     //var_dump(\Yii::$app->params); exit();
        $script  = "var uptoken_url = '".$this->uptoken_url."';";
        $script  .= " var keys = ".$this->keys."; ";
        $script .= "var qiniu_domain ='".\Yii::$app->params['qiniu']['wakooedu']['domain'].'/'."';";

// $script .= "var delete_url = '".$this->delete_url."';";
        if($this->zone_url != false){
            $script .= "var zone_url = '".$this->zone_url."';";
        }
//var_dump('<pre>',$script);exit;
        $this->view->registerJs($script, View::POS_BEGIN);
        AssetStudentRecordValue::register($this->view);
    }
}