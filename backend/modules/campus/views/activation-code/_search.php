<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\search\ActivationCodeSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="activation-code-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'activation_code_id') ?>

    <?php echo $form->field($model, 'activation_code') ?>

    <?php echo $form->field($model, 'courseware_id') ?>

    <?php echo $form->field($model, 'course_order_item_id') ?>

    <?php echo $form->field($model, 'school_id') ?>

    <?php // echo $form->field($model, 'grade_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'introducer_id') ?>

    <?php // echo $form->field($model, 'payment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'total_price') ?>

    <?php // echo $form->field($model, 'real_price') ?>

    <?php // echo $form->field($model, 'coupon_price') ?>

    <?php // echo $form->field($model, 'coupon_type') ?>

    <?php // echo $form->field($model, 'expired_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
