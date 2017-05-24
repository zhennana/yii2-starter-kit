<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\CourseOrderItemSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="course-order-item-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'course_order_item_id') ?>

		<?= $form->field($model, 'parent_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'grade_id') ?>

		<?= $form->field($model, 'user_id') ?>

		<?php // echo $form->field($model, 'introducer_id') ?>

		<?php // echo $form->field($model, 'payment') ?>

		<?php // echo $form->field($model, 'presented_course') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'payment_status') ?>

		<?php // echo $form->field($model, 'total_price') ?>

		<?php // echo $form->field($model, 'real_price') ?>

		<?php // echo $form->field($model, 'coupon_price') ?>

		<?php // echo $form->field($model, 'total_course') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cruds', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cruds', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
