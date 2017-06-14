<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

?>
<div class="gdu-content">
  <div class="">
    <!-- 文章内容部分 -->
    <div class="col-md-12 ">
      <div class="box box-widget geu-content">
            <div class="box-header with-border" >
              <ol class="breadcrumb">
                  <li><?php echo Html::a('首页',['site/index'])?></li>
                  <li>在线报名</li>
              </ol>
            </div>
      </div>
      <div class="box-body geu-content">
        <!-- <div class="row">
          <div class="col-xs-12" >
           <div class="apply">
            <div><a>在线报名</a></div>
          </div>
          </div>
        </div> -->

        <div class="row btn-line">
          <div class="col-xs-4">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>学生姓名</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>性&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp别</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>出生日期</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
        </div>

        <div class="row btn-line">
          <div class="col-xs-4">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>民&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp族</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>监护人姓名</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>手机号码</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
        </div>
        <div class="row btn-line" >
          <div class="col-xs-4">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>邮&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp箱</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-8">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn btncolor"><i class="fa fa-fw fa-star text-red"></i>籍贯</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
        </div>
        <div class="row btn-line">
          <div class="col-xs-12">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn btncolor">个人简介</button>
            </div>
            <!-- /btn-group -->
            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
          </div>
          </div>
        </div>
        <div class="box-footer geu-content">
                <button type="submit" class="btn bg-purple margin pull-right">点击提交</button>
              </div>
      </div>

    </div>
  </div>

