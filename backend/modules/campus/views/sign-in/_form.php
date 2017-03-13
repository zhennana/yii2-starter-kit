<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="sign-in-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'SignIn',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->textInput() ?>

<!-- attribute grade_id -->
			<?= $form->field($model, 'grade_id')->textInput() ?>

<!-- attribute course_id -->
			<?= $form->field($model, 'course_id')->textInput() ?>

<!-- attribute student_id -->
			<?= $form->field($model, 'student_id')->textInput() ?>

<!-- attribute teacher_id -->
			<?= $form->field($model, 'teacher_id')->textInput() ?>

<!-- attribute auditor_id -->
			<?= $form->field($model, 'auditor_id')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

        </p>

        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [ 
                [
                    'label'   => ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '更新')),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '更新')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

