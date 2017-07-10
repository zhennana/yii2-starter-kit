<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\WorkRecord $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="work-record-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WorkRecord',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute auditer_id -->
			<?= $form->field($model, 'auditer_id')->textInput() ?>

<!-- attribute body -->
			<?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'WorkRecord'),
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

