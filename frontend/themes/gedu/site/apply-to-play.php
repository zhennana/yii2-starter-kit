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
    <div class="col-md-12 " style="padding:0;margin-bottom:30px;">
      <div class="box box-widget geu-content">
            <div class="box-header with-border" >
              <ol class="breadcrumb">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['site/index'])?></li>
                  <li class="activeli">在线报名</li>
              </ol>
            </div>
      </div>
      <div class="box-body geu-content">
         <?php
            if (Yii::$app->session->hasFlash('info')) {
                echo Yii::$app->session->getFlash('info');
            }
            $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
                ],
                'options' => [
                    'class' => 'new_user_form inline-input',
                ],
            ]);
        ?>

        <div class="row btn-line">
        <!-- 姓名 -->
          <div class="col-xs-12 col-md-4">
           <div class="input-group text-two">
            <span class="applystar col-xs-1"><i class="fa fa-fw fa-star text-red"></i></span>
            <?php echo $form->field($model, 'username')->textInput(['class' => 'span4 col-xs-9']);?>
          </div>
          </div>
          <!-- 性别 -->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar col-xs-1"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'gender')->dropDownList(['1'=>'男','2'=>'女'], ['prompt'=>'请选择','class' => 'span4 col-xs-9']);?>
            </div>
          </div>
          <!-- 年龄-->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar col-xs-1"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'age')->textInput(['class' => 'span4 col-xs-9']);?>
            </div>
          </div>
        </div>
        <div class="row btn-line">
<!-- 民族-->
          <div class="col-xs-12 col-md-4">
           <div class="input-group text-two">
            <span class="applystar col-xs-1"><i ></i></span><?php echo $form->field($model, 'nation')->textInput(['class' => 'span4 col-xs-9']);?>
          </div>
          </div>
          <!-- 监护人-->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-three">
              <span class="applystar col-xs-1"><i ></i></span><?php echo $form->field($model, 'guardian')->textInput(['class' => 'span4 col-xs-9']);?>
            </div>
          </div>
          <!-- 电话-->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar col-xs-1"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'phone_number')->textInput(['class' => 'span4 col-xs-9']);?>
            </div>
          </div>
        </div>

        <!-- 第三行 -->
        <div class="row btn-line" >
        <!-- 邮件-->
          <div class="col-xs-12 col-md-4">
           <div class="input-group text-two">
            <span class="applystar col-xs-1"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'email')->textInput(['class' => 'span4 col-xs-9']);?>
          </div>
          </div>
          <!-- 详细地址-->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-three">
              <span class="applystar col-xs-1"><i ></i></span><?php  echo $form->field($model, 'address')->textInput(['class' => 'span4 col-xs-9']);?>
            </div>
          </div>
        </div>
        <div class="row btn-line">
        <!-- 简介-->
         <!-- <div class=" jianjiebox col-xs-12">
           <div class="input-group text-four">
            <span class="applystar jianjie"><i></i></span><?php  echo $form->field($model, 'body')->textarea(['rows'=>3,'class' => 'span3']);?>
          </div>
          </div>-->
          <div class="col-xs-12" style="padding-right:0;">
              <div class="input-group text-four">
                <span class="applystar" style="padding-left:15px;font-size:12px;">（备注：带<i class="fa fa-fw fa-star text-red"></i>为必填项）</span>
              </div>
          </div>
        </div>
        <div class="box-footer">
                <?php echo Html::submitButton('点击提交', ['class' => 'btn bg-purple margin pull-right']); ?>
        </div>
        <?php ActiveForm::end(); ?>
      </div>

    </div>
  </div>
  </div>

