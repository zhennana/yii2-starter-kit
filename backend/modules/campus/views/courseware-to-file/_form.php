<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/4b7e79a8340461fe629a6ac612644d03
 *
 * @package default
 */

use yii\helpers\Html;
use yii\helpers\StringHelper;
use \yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use backend\modules\campus\models\Courseware;
use backend\modules\campus\models\CoursewareToFile;
use backend\modules\campus\models\FileStorageItem;
/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareToFile $model
 * @var yii\widgets\ActiveForm $form
 */
$files = FileStorageItem::find()->where(['status' => FileStorageItem::STORAGE_STATUS_OPEN])->all();
$files = ArrayHelper::map($files, 'file_storage_item_id', 'original');

$coursewares = Courseware::find()->where(['status' => Courseware::COURSEWARE_STATUS_VALID])->all();
$coursewares = ArrayHelper::map($coursewares, 'courseware_id', 'title');

?>

<div class="courseware-to-file-form">

    <?php $form = ActiveForm::begin([
		'id' => 'CoursewareToFile',
		'layout' => 'horizontal',
		'enableClientValidation' => true,
		'errorSummaryCssClass' => 'error-summary alert alert-error'
	]
);
?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>


<!-- attribute file_storage_item_id -->
			<?php echo $form->field($model, 'file_storage_item_id')->widget(Select2::className(),[
                'data' => $files,
                 'disabled' => true,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ])->label('文件名') ?>

<!-- attribute courseware_id -->
			<?php echo $form->field($model, 'courseware_id')->widget(Select2::className(),[
                'data' => $coursewares,
                 'disabled' => true,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ]) ?>

<!-- attribute status -->
			<?php echo $form->field($model, 'status')->widget(Select2::className(),[
                'data'          => backend\modules\campus\models\CoursewareToFile::optsStatus(),
                'hideSearch'    => true,
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

<!-- attribute sort -->
			<?php echo $form->field($model, 'sort')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>

        <?php echo
Tabs::widget(
	[
		'encodeLabels' => false,
		'items' => [
			[
				'label'   => Yii::t('backend', 'CoursewareToFile'),
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
