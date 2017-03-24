<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\ContactSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="contact-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'contact_id') ?>

		<?= $form->field($model, 'username') ?>

		<?= $form->field($model, 'auditor_id') ?>

		<?= $form->field($model, 'phone_number') ?>

		<?= $form->field($model, 'email') ?>

		<?php // echo $form->field($model, 'body') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('common', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
