<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\ActivationCode */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="activation-code-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'activation_code')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'courseware_id')->textInput() ?>

    <?php echo $form->field($model, 'course_order_item_id')->textInput() ?>

    <?php echo $form->field($model, 'school_id')->textInput() ?>

    <?php echo $form->field($model, 'grade_id')->textInput() ?>

    <?php echo $form->field($model, 'user_id')->textInput() ?>

    <?php echo $form->field($model, 'introducer_id')->textInput() ?>

    <?php echo $form->field($model, 'payment')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'real_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'coupon_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'coupon_type')->textInput() ?>

    <?php echo $form->field($model, 'expired_at')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
