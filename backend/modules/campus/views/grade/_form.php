<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Grade $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="grade-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Grade',
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

<!-- attribute grade_title -->
			<?= $form->field($model, 'grade_title')->textInput() ?>

<!-- attribute creater_id -->
			<?= $form->field($model, 'creater_id')->textInput() ?>

<!-- attribute classroom_group_levels -->
			<?= $form->field($model, 'classroom_group_levels')->textInput() ?>

<!-- attribute owner_id -->
			<?= $form->field($model, 'owner_id')->textInput() ?>

<!-- attribute sort -->
			<?= $form->field($model, 'sort')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute graduate -->
			<?= $form->field($model, 'graduate')->textInput() ?>

<!-- attribute time_of_graduation -->
			<?= $form->field($model, 'time_of_graduation')->textInput() ?>

<!-- attribute time_of_enrollment -->
			<?= $form->field($model, 'time_of_enrollment')->textInput() ?>

<!-- attribute grade_name -->
			<?= $form->field($model, 'grade_name')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'Grade'),
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

