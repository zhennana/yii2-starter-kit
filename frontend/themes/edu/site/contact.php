<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ContactForm */

$this->title = '联系我们';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content">
    <article class="article-item">
        <div class="col-sm-8">
            <h1><?php echo Html::encode($this->title) ?></h1>
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?php echo $form->field($model, 'username') ?>.
                <?php echo $form->field($model,'phone_number') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php //echo $form->field($model, 'subject') ?>
                <?php echo $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                <?php echo $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'captchaAction'=>'site/contact_captcha',
                    'template' => '<div class="row"><div class="col-lg-6">{input}</div><div class="col-lg-3">{image}</div></div>',
                    'imageOptions'=>['alt'=>'图片无法加载','title'=>'点击换图', 'style'=>'cursor:pointer'],
                ]) ?>
                <div class="form-group">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php echo $this->render('@frontend/themes/edu/page/right-side'); ?>
    </article>
</div>
