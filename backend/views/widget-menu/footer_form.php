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
    <div class="col-xs-12">
        <div class="col-xs-12">
            <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>
            <?php echo $form->field($model, '[body]sort')->textInput(['value'=>isset($model->body['sort']) ? $model->body['sort']  : '' ]) ?>
        </div>
<!-- 只让他添加8次 -->

            <?php for($i=0;$i <= 7;$i++){?>
                <?php
                    foreach ($model->footer_label as $key => $value) {
                ?>
                <div class="col-xs-6">
                    <?php echo $form->field($model,'[body]['.$i.']'.$value)->textInput(['value'=>isset($model->body[$i][$value]) && is_string($model->body[$i][$value]) ?  $model->body[$i][$value] : ''])?>
                </div>
            <?php }} ?>

        <div class="col-xs-12">
            <?php echo $form->field($model, 'status')->checkbox() ?>
        </div>
        <div class="form-group col-xs-12 ">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
