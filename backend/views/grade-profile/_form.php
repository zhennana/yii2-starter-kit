<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\grade\GradeProfile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grade-profile-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grade_id')->textInput() ?>

    <?= $form->field($model, 'grade_storage_space')->textInput() ?>

    <?= $form->field($model, 'student_sum')->textInput() ?>

    <?= $form->field($model, 'teacher_sum')->textInput() ?>

    <?= $form->field($model, 'article_sum')->textInput() ?>

    <?= $form->field($model, 'page_sum')->textInput() ?>

    <?= $form->field($model, 'album_sum')->textInput() ?>

    <?= $form->field($model, 'levels')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
