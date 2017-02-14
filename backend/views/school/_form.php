<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\school\School */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="school-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'parent_id')->textInput() ?>

    <?php echo $form->field($model, 'school_id')->textInput() ?>

    <?php echo $form->field($model, 'language')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'school_title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'school_short_title')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'school_slogan')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'school_logo_path')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'school_backgroud_path')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'longitude')->textInput() ?>

    <?php echo $form->field($model, 'latitude')->textInput() ?>

    <?php echo $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'province_id')->textInput() ?>

    <?php echo $form->field($model, 'city_id')->textInput() ?>

    <?php echo $form->field($model, 'region_id')->textInput() ?>

    <?php echo $form->field($model, 'created_at')->textInput() ?>

    <?php echo $form->field($model, 'updated_at')->textInput() ?>

    <?php echo $form->field($model, 'created_id')->textInput() ?>

    <?php echo $form->field($model, 'status')->textInput() ?>

    <?php echo $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
