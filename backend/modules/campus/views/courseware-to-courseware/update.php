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
 * @var backend\modules\campus\models\CoursewareToCourseware $model
 */
$this->title = Yii::t('backend', '修改课件关系') . " " . $model->courseware_to_courseware_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Courseware'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->courseware_to_courseware_id, 'url' => ['view', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud courseware-to-courseware-update">

    <h1>
        <?php echo Yii::t('backend', '修改课件关系') ?>
        <small>
            <?php echo $model->courseware_to_courseware_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?php echo Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '详情'), ['view', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
		'model' => $model,
        'courseware_ids'=>$courseware_ids,
        'courseware'=>$courseware
	]); ?>

</div>
