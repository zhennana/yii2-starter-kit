<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\search\CourseCategory */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="course-category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'category_id') ?>

    <?php echo $form->field($model, 'parent_id') ?>

    <?php echo $form->field($model, 'name') ?>

    <?php echo $form->field($model, 'slug') ?>

    <?php echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'banner_src') ?>

    <?php // echo $form->field($model, 'creater_id') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
