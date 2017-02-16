<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\CoursewareSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="courseware-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'courseware_id') ?>

		<?= $form->field($model, 'category_id') ?>

		<?= $form->field($model, 'level') ?>

		<?= $form->field($model, 'creater_id') ?>

		<?= $form->field($model, 'slug') ?>

		<?php // echo $form->field($model, 'title') ?>

		<?php // echo $form->field($model, 'body') ?>

		<?php // echo $form->field($model, 'parent_id') ?>

		<?php // echo $form->field($model, 'access_domain') ?>

		<?php // echo $form->field($model, 'access_other') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'items') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
