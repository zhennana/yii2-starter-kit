<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStreamToGrade $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="share-stream-to-grade-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ShareStreamToGrade',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute share_stream_id -->
			<?= $form->field($model, 'share_stream_id')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute auditor_id -->
			<?= $form->field($model, 'auditor_id')->textInput() ?>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->textInput(['maxlength' => true]) ?>

<!-- attribute grade_id -->
			<?= $form->field($model, 'grade_id')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'ShareStreamToGrade'),
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

