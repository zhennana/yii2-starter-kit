<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/fcd70a9bfdf8de75128d795dfc948a74
 *
 * @package default
 */


use yii\helpers\Html;

/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareToFile $model
 */
$this->title = Yii::t('backend', 'Courseware To File') . " " . $model->courseware_to_file_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To File'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->courseware_to_file_id, 'url' => ['view', 'courseware_to_file_id' => $model->courseware_to_file_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud courseware-to-file-update">

    <h1>
        <?php echo Yii::t('backend', 'Courseware To File') ?>
        <small>
                        <?php echo $model->courseware_to_file_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?php echo Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'courseware_to_file_id' => $model->courseware_to_file_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
