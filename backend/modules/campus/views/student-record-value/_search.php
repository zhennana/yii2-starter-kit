<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\StudentRecordValueSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="student-record-value-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'student_record_value_id') ?>

		<?= $form->field($model, 'student_record_key_id') ?>

		<?= $form->field($model, 'student_record_id') ?>

		<?= $form->field($model, 'body') ?>

		<?= $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'sort') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
