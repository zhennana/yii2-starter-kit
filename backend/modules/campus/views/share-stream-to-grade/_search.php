<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStreamToGradeSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="share-stream-to-grade-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'share_stream_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'grade_id') ?>

		<?= $form->field($model, 'status') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'auditor_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
