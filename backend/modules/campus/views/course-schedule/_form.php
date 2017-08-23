<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use \kartik\select2\Select2;
use \backend\modules\campus\models\CourseSchedule;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseSchedule $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="course-schedule-form">

    <?php $form = ActiveForm::begin([
    'id' => 'CourseSchedule',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>


<!-- attribute course_id -->
			<?= $form->field($model, 'course_id')->textInput(['readonly'=>'readonly' ]) ?>

<!-- attribute start_time -->
			<?= $form->field($model, 'start_time')->textInput(['readonly'=>'readonly' ]) ?>

<!-- attribute end_time -->
			<?= $form->field($model, 'end_time')->textInput(['readonly'=>'readonly' ]) ?>

<!-- attribute which_day -->
			<?= $form->field($model, 'which_day')->textInput(['readonly'=>'readonly' ]) ?>
            <?= $form->field($model, 'status')->widget(Select2::className(),
                [
                    'data'          => CourseSchedule::optsStatus(),
                    'options'       => ['placeholder' => '请选择' ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'CourseSchedule'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
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

</div>

