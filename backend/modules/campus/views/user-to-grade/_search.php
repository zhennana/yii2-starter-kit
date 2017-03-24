<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\UserToGradeSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="user-to-grade-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'user_to_grade_id') ?>

		<?= $form->field($model, 'user_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'grade_id') ?>

		<?= $form->field($model, 'user_title_id_at_grade') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'sort') ?>

		<?php // echo $form->field($model, 'grade_user_type') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
