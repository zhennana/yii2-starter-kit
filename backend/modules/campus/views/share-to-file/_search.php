<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\ShareToFileSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="share-to-file-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'share_to_file_id') ?>

		<?= $form->field($model, 'share_stream_id') ?>

		<?= $form->field($model, 'file_storage_item_id') ?>

		<?= $form->field($model, 'status') ?>

		<?= $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
