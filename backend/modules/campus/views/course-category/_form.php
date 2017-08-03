<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\modules\campus\models\CourseCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\CourseCategory */
/* @var $form yii\bootstrap\ActiveForm */
if ($model->isNewRecord) {
    $parents = CourseCategory::find()
        ->where(['parent_id' => 0])
        ->all();
}else{
    $parents = CourseCategory::find()
        ->where(['parent_id' => 0])
        ->andWhere(['<>','category_id',$model->category_id])
        ->all();
}
$parents = \yii\helpers\ArrayHelper::map($parents, 'category_id', 'name');

?>

<div class="course-category-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'CourseCategory',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>


    <?= $form->field($model, 'parent_id')->widget(Select2::className(),[
        'data'    => $parents,
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [ 
            'allowClear' => true
        ],
    ]); ?>

    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'description')->textArea(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'banner_src')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'creater_id')->textInput() ?>

    <?= $form->field($model, 'status')->widget(Select2::className(),[
        'data'          => CourseCategory::optsStatus(),
        'hideSearch'    => true,
        'options'       => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

</div>
