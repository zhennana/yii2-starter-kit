<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="widget-menu-form">
    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model) ?>
    <div class="col-xs-12 ">
        <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>
        <?php
            foreach ($model->contact as $key => $value) {
                 echo   $form->field($model, '[body]'.$key)->textInput(['value'=>isset($model->body[$key]) && is_string($model->body[$key]) ? $model->body[$key] : '']);
            }
        ?>
        <?php echo $form->field($model, 'status')->checkbox() ?>

        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>