<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ApplyToPlay $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="apply-to-play-form">

    <?php $form = ActiveForm::begin([
    'id' => 'ApplyToPlay',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute username -->
			<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<!-- attribute phone_number -->
			<?= $form->field($model, 'phone_number')->textInput() ?>

<!-- attribute email -->
			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<!-- attribute city -->
			<?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

<!-- attribute province -->
			<?= $form->field($model, 'province')->textInput(['maxlength' => true]) ?>

<!-- attribute verifyCode -->

<!-- attribute region -->
			<?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute auditor_id -->
			<?= $form->field($model, 'auditor_id')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('common', 'ApplyToPlay'),
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

