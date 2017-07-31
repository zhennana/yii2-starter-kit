<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\CourseScheduleSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="course-schedule-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'course_schedule_id') ?>

		<?= $form->field($model, 'course_id') ?>

		<?= $form->field($model, 'start_time') ?>

		<?= $form->field($model, 'end_time') ?>

		<?= $form->field($model, 'which_day') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
