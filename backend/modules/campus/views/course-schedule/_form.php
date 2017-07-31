<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

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
			<?= $form->field($model, 'course_id')->textInput() ?>

<!-- attribute start_time -->
			<?= $form->field($model, 'start_time')->textInput() ?>

<!-- attribute end_time -->
			<?= $form->field($model, 'end_time')->textInput() ?>

<!-- attribute which_day -->
			<?= $form->field($model, 'which_day')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>
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

