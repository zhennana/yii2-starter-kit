<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\School $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="school-form">

    <?php $form = ActiveForm::begin([
    'id' => 'School',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
			<?= $form->field($model, 'id')->textInput() ?>
			<?= $form->field($model, 'parent_id')->textInput() ?>
			<?= $form->field($model, 'school_id')->textInput() ?>
			<?= $form->field($model, 'language')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'school_title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'school_short_title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'school_slogan')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'school_logo_path')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'school_backgroud_path')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'longitude')->textInput() ?>
			<?= $form->field($model, 'latitude')->textInput() ?>
			<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'province_id')->textInput() ?>
			<?= $form->field($model, 'city_id')->textInput() ?>
			<?= $form->field($model, 'region_id')->textInput() ?>
			<?= $form->field($model, 'created_at')->textInput() ?>
			<?= $form->field($model, 'updated_at')->textInput() ?>
			<?= $form->field($model, 'created_id')->textInput() ?>
			<?= $form->field($model, 'status')->textInput() ?>
			<?= $form->field($model, 'sort')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                   'encodeLabels' => false,
                     'items' => [ [
    'label'   => Yii::t('backend', StringHelper::basename('backend\modules\campus\models\School')),
    'content' => $this->blocks['main'],
    'active'  => true,
], ]
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

