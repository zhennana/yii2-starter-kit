<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Notice $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="notice-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Notice',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute message -->
			<?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

<!-- attribute sender_id -->
			<?= $form->field($model, 'sender_id')->textInput() ?>

<!-- attribute receiver_id -->
			<?= $form->field($model, 'receiver_id')->textInput() ?>

<!-- attribute is_sms -->
			<?= $form->field($model, 'is_sms')->textInput() ?>

<!-- attribute is_wechat_message -->
			<?= $form->field($model, 'is_wechat_message')->textInput() ?>

<!-- attribute times -->
			<?= $form->field($model, 'times')->textInput() ?>

<!-- attribute status_send -->
			<?= $form->field($model, 'status_send')->textInput() ?>

<!-- attribute status_check -->
			<?= $form->field($model, 'status_check')->textInput() ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute message_hash -->
			<?= $form->field($model, 'message_hash')->textInput(['maxlength' => true]) ?>

<!-- attribute receiver_name -->
			<?= $form->field($model, 'receiver_name')->textInput(['maxlength' => true]) ?>

<!-- attribute wechat_message_id -->
			<?= $form->field($model, 'wechat_message_id')->textInput(['maxlength' => true]) ?>

<!-- attribute receiver_phone_numeber -->
			<?= $form->field($model, 'receiver_phone_numeber')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'Notice'),
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

