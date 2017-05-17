<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\NoticeSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="notice-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'notice_id') ?>

		<?= $form->field($model, 'category') ?>

		<?= $form->field($model, 'title') ?>

		<?= $form->field($model, 'message') ?>

		<?= $form->field($model, 'message_hash') ?>

		<?php // echo $form->field($model, 'sender_id') ?>

		<?php // echo $form->field($model, 'receiver_id') ?>

		<?php // echo $form->field($model, 'receiver_phone_numeber') ?>

		<?php // echo $form->field($model, 'receiver_name') ?>

		<?php // echo $form->field($model, 'is_sms') ?>

		<?php // echo $form->field($model, 'is_wechat_message') ?>

		<?php // echo $form->field($model, 'wechat_message_id') ?>

		<?php // echo $form->field($model, 'times') ?>

		<?php // echo $form->field($model, 'status_send') ?>

		<?php // echo $form->field($model, 'status_check') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
