<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\LoginForm */

$this->title = Yii::t('frontend', 'Login');
$logo = 'http://orfaphl6n.bkt.clouddn.com/logo.png';
?>
<div class="login-box">
    <div class="login-logo">
        <a href="<?php echo Yii::getAlias('@frontendUrl') ?>">
            <img class="img-responsive center-block" src="<?= $logo ?>">
        </a>
        <?php // echo Html::encode($this->title) ?>
    </div>
    <!-- /.login-logo -->

    <div class="header"></div>
    <div class="login-box-body">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="body has-feedback">
            <?php echo $form->field($model, 'identity',[
                'template' => "{label}\n{input}<span class=\"fa fa-user form-control-feedback\"></span>{error}",
            ])->textInput() ?>
        </div>
        <div class="body has-feedback">
            <?php echo $form->field($model, 'password',[
                'template' => "{label}\n{input}<span class=\"fa fa-key form-control-feedback\"></span>{error}",
            ])->passwordInput() ?>
            <?php echo $form->field($model, 'rememberMe')->checkbox(['class'=>'simple']) ?>
        </div>
        <div class="footer">
            <?php echo Html::submitButton(Yii::t('frontend', 'Login'), [
                'class' => 'btn btn-info btn-flat btn-block',
                'name' => 'login-button'
            ]) ?>
            <div class="text-center" style="color:#999;margin:1em 0">
                    <?php echo Yii::t('frontend', 'If you forgot your password you can reset it <a href="{link}">here</a>', [
                        'link'=>yii\helpers\Url::to(['sign-in/request-password-reset'])
                    ]) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>