<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\CoursewareSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="courseware-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'courseware_id') ?>

    <?php echo $form->field($model, 'category_id') ?>

    <?php echo $form->field($model, 'level') ?>

    <?php echo $form->field($model, 'creater_id') ?>

    <?php echo $form->field($model, 'slug') ?>

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
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
