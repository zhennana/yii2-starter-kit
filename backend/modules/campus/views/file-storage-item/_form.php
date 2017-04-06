<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use backend\modules\campus\models\FileStorageItem;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\FileStorageItem $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="file-storage-item-form">

    <?php $form = ActiveForm::begin([
    'id' => 'FileStorageItem',
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
		<!-- 	<? //= //$form->field($model, 'user_id')->textInput() ?> -->

<!-- attribute school_id -->
		<!-- 	<? // $form->field($model, 'school_id')->textInput() ?>
 -->
<!-- attribute grade_id -->
	<!-- 		<?// $form->field($model, 'grade_id')->textInput() ?>
 -->
<!-- attribute file_category_id -->
			<!-- <?// $form->field($model, 'file_category_id')->textInput() ?>
 -->


<!-- attribute ispublic -->
			<!-- <?// $form->field($model, 'ispublic')->textInput() ?>
 -->


<!-- attribute page_view -->
		<!-- 	<?// $form->field($model, 'page_view')->textInput() ?> -->


<!-- attribute url -->
			<?= $form->field($model, 'url')->textInput(['maxlength' => true,'disabled' => true]) ?>
<!-- attribute file_name -->
            <?= $form->field($model, 'file_name')->textInput(['maxlength' => true,'disabled' => true]) ?>

<!-- attribute type -->
			<?= $form->field($model, 'type')->textInput(['maxlength' => true,'disabled' => true]) ?>
<!-- attribute component -->
            <?= $form->field($model, 'component')->textInput(['maxlength' => true,'disabled' => true]) ?>
<!-- attribute size -->
            <?= $form->field($model, 'size')->textInput(['disabled' => true]) ?>
<!-- attribute sort_rank -->
            <?= $form->field($model, 'sort_rank')->textInput() ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->dropDownList(FileStorageItem::optsStatus()) ?>




<!-- attribute upload_ip -->
			<!-- <?// $form->field($model, 'upload_ip')->textInput(['maxlength' => true]) ?> -->

<!-- attribute original -->
		<!--   -->
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'FileStorageItem'),
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

