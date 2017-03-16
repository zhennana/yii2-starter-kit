<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="course-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Course',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->textInput() ?>

<!-- attribute grade_id -->
			<?= $form->field($model, 'grade_id')->textInput() ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute intro -->
			<?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

<!-- attribute courseware_id -->
			<?= $form->field($model, 'courseware_id')->textInput() ?>

<!-- attribute creater_id -->
			<?= $form->field($model, 'creater_id')->textInput() ?>

<!-- attribute start_time -->
			<?= $form->field($model, 'start_time')->textInput() ?>

<!-- attribute end_time -->
			<?= $form->field($model, 'end_time')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute updeated_at -->
			<?= $form->field($model, 'updeated_at')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'Course'),
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
        ($model->isNewRecord ? Yii::t('common', 'Create') : Yii::t('common', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

