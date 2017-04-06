<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/4b7e79a8340461fe629a6ac612644d03
 *
 * @package default
 */


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareCategory $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="courseware-category-form">

    <?php $form = ActiveForm::begin([
		'id' => 'CoursewareCategory',
		'layout' => 'horizontal',
		'enableClientValidation' => true,
		'errorSummaryCssClass' => 'error-summary alert alert-error'
	]
);
?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>


<!-- attribute parent_id -->
			<?php //echo $form->field($model, 'parent_id')->textInput() ?>

<!-- attribute creater_id -->
			<?= $form->field($model, 'creater_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false)->hint(false) ?>

<!-- attribute name -->
			<?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<!-- attribute description -->
			<?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<!-- attribute banner_src -->
			<?php echo $form->field($model, 'banner_src')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'status')->dropDownList(\backend\modules\campus\models\CoursewareCategory::optsStatus(),['prompt'=>'请选择']); ?>

        </p>
        <?php $this->endBlock(); ?>

        <?php echo
Tabs::widget(
	[
		'encodeLabels' => false,
		'items' => [
			[
				'label'   => Yii::t('backend', '创建课程分类'),
				'content' => $this->blocks['main'],
				'active'  => true,
			],
		]
	]
);
?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?php echo Html::submitButton(
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
