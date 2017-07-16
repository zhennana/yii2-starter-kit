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
            <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span>
            <?php echo $form->field($model, 'username')->textInput(['class' => 'span4']);?>
          </div>
          </div>
          <!-- 性别 -->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'gender')->dropDownList(['1'=>'男','2'=>'女'], ['prompt'=>'请选择','class' => 'span4']);?>
            </div>
          </div>
          <!-- 年龄-->
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'age')->textInput(['class' => 'span4']);?>
            </div>
          </div>
        </div>
        <div class="row btn-line">
          <div class="col-xs-12 col-md-4">
           <div class="input-group text-two">
            <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'nation')->textInput(['class' => 'span4']);?>
          </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-three">
              <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'guardian')->textInput(['class' => 'span4']);?>
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group text-two">
              <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'phone_number')->textInput(['class' => 'span4']);?>
            </div>
          </div>
        </div>

        <!-- 第三行 -->
        <div class="row btn-line" >
          <div class="col-xs-12 col-md-4">
           <div class="input-group text-two">
            <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php echo $form->field($model, 'email')->textInput(['class' => 'span4']);?>
          </div>
          </div>
          <div class="col-xs-12 col-md-8">
            <div class="input-group text-three">
              <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'address')->textInput(['class' => 'span8']);?>
            </div>
          </div>
        </div>
        <div class="row btn-line ">
          <div class="col-xs-12">
           <div class="input-group text-three">
            <span class="applystar"><i class="fa fa-fw fa-star text-red"></i></span><?php  echo $form->field($model, 'body')->textarea(['rows'=>3,'class' => 'span12']);?>
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

