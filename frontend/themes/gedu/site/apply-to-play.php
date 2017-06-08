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
              <div class="">
                <span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i><a href="#">当前位置:首页>在线报名</a></span>
              </div>
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
          <div class="col-xs-3">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>学生姓名</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>性别</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
          <div class="col-xs-5">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>出生日期</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
        </div>

        <div class="row btn-line">
          <div class="col-xs-3">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>民族</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-4">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>监护人姓名</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
          <div class="col-xs-5">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>手机号码</button>
              </div>
              <!-- /btn-group -->
              <input class="form-control" type="text">
            </div>
          </div>
        </div>
        <div class="row btn-line" >
          <div class="col-xs-3">
           <div class="input-group">
            <div class="input-group-btn">
              <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>邮箱</button>
            </div>
            <!-- /btn-group -->
            <input class="form-control" type="text">
          </div>
          </div>
          <div class="col-xs-9">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" class="btn"><i class="fa fa-fw fa-star text-red"></i>籍贯</button>
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
              <button type="button" class="btn">个人简介</button>
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

