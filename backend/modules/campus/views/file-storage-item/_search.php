<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\search\FileStorageItemSearch $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="file-storage-item-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    ]); ?>

    		<?= $form->field($model, 'file_storage_item_id') ?>

		<?= $form->field($model, 'user_id') ?>

		<?= $form->field($model, 'school_id') ?>

		<?= $form->field($model, 'grade_id') ?>

		<?= $form->field($model, 'file_category_id') ?>

		<?php // echo $form->field($model, 'type') ?>

		<?php // echo $form->field($model, 'size') ?>

		<?php // echo $form->field($model, 'component') ?>

		<?php // echo $form->field($model, 'upload_ip') ?>

		<?php // echo $form->field($model, 'ispublic') ?>

		<?php // echo $form->field($model, 'file_name') ?>

		<?php // echo $form->field($model, 'url') ?>

		<?php // echo $form->field($model, 'original') ?>

		<?php // echo $form->field($model, 'updated_at') ?>

		<?php // echo $form->field($model, 'created_at') ?>

		<?php // echo $form->field($model, 'status') ?>

		<?php // echo $form->field($model, 'page_view') ?>

		<?php // echo $form->field($model, 'sort_rank') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
