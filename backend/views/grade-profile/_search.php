<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\GradeProfileSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-profile-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'grade_id') ?>

    <?= $form->field($model, 'grade_storage_space') ?>

    <?= $form->field($model, 'student_sum') ?>

    <?= $form->field($model, 'teacher_sum') ?>

    <?= $form->field($model, 'article_sum') ?>

    <?php // echo $form->field($model, 'page_sum') ?>

    <?php // echo $form->field($model, 'album_sum') ?>

    <?php // echo $form->field($model, 'levels') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
