<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\CourseSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

		<?= $form->field($model, 'course_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'grade_id') ?>

		<?= $form->field($model, 'title') ?>

		<?= $form->field($model, 'intro') ?>

		<?php // echo $form->field($model, 'courseware_id') ?>

		<?php // echo $form->field($model, 'creater_id') ?>

		<?php // echo $form->field($model, 'start_time') ?>

		<?php // echo $form->field($model, 'end_time') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updeated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', '搜索'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', '重置'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
