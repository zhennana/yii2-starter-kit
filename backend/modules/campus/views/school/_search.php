<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\SchoolSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="school-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'id') ?>

		<?= $form->field($model, 'parent_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'language') ?>

		<?= $form->field($model, 'school_title') ?>

		<?php // echo $form->field($model, 'school_short_title') ?>

		<?php // echo $form->field($model, 'school_slogan') ?>

		<?php // echo $form->field($model, 'school_logo_path') ?>

		<?php // echo $form->field($model, 'school_backgroud_path') ?>

		<?php // echo $form->field($model, 'longitude') ?>

		<?php // echo $form->field($model, 'latitude') ?>

		<?php // echo $form->field($model, 'address') ?>

		<?php // echo $form->field($model, 'province_id') ?>

		<?php // echo $form->field($model, 'city_id') ?>

		<?php // echo $form->field($model, 'region_id') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_id') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'sort') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', '搜索'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', '重置'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
