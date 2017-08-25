<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\modules\user\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
?>

<div class="gdu-content">
    <div class="box box-widget geu-content">
            <div class="box-header with-border">
            <ol class="breadcrumb">
                  <li><span class=""><i class="fa fa-map-marker margin-r-5 text-purple"></i>当前位置: </span>&nbsp<?php echo Html::a('首页',['/site/index'])?></li>
                  <li class="activeli">登录</li>
            </ol></div>
            <div class="site-login content">
                <h1 style="font-size:24px;padding-left:15px;"><?php echo Html::encode($this->title) ?></h1>

                <div class="row">
                    <div class="col-xs-12">
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                            <?php echo $form->field($model, 'identity') ?>
                            <?php echo $form->field($model, 'password')->passwordInput() ?>
                            <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                            <!--<div class="form-group" style="color:#999;">
                               /*<div class="display:block;">
                                    <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                                                                   'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                                                               ]) ?>
                               </div>*/
                            </div>-->
                            <div class="form-group">
                                <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary btn-submit', 'name' => 'login-button']) ?>
                            </div>
                            <div class="form-group">
                                <?php // echo Html::a(Yii::t('frontend', 'Need an account? Sign up.'), ['signup']) ?>
                            </div>
                            <!--
                            <h2><?php //echo Yii::t('frontend', 'Log in with')  ?>:</h2>
                            <div class="form-group">
                                <?php /*
                                echo yii\authclient\widgets\AuthChoice::widget([
                                    'baseAuthUrl' => ['/user/sign-in/oauth']
                                ]);
                                */ ?>
                            </div>
                            -->
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
    </div>

</div>
 <script>
        $('.carousel').hide();
    </script>
