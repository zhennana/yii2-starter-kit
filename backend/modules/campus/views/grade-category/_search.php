<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\GradeCategorySearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="grade-categroy-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'grade_category_id') ?>

		<?= $form->field($model, 'parent_id') ?>

		<?= $form->field($model, 'name') ?>

		<?= $form->field($model, 'creater_id') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('cruds', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('cruds', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
