<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/d4b4964a63cc95065fa0ae19074007ee
 *
 * @package default
 */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareToFile $model
 */
$copyParams = $model->attributes;

$this->title = Yii::t('backend', 'Courseware To File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->courseware_to_file_id, 'url' => ['view', 'courseware_to_file_id' => $model->courseware_to_file_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud courseware-to-file-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?php echo \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?php echo Yii::t('backend', 'Courseware To File') ?>
        <small>
            <?php echo $model->courseware_to_file_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php echo Html::a(
	'<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
	[ 'update', 'courseware_to_file_id' => $model->courseware_to_file_id],
	['class' => 'btn btn-info']) ?>

            <?php echo Html::a(
	'<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
	['create', 'courseware_to_file_id' => $model->courseware_to_file_id, 'CoursewareToFile'=>$copyParams],
	['class' => 'btn btn-success']) ?>

            <?php echo Html::a(
	'<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'),
	['create'],
	['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?php echo Html::a('<span class="glyphicon glyphicon-list"></span> '
	. Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\CoursewareToFile'); ?>


    <?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'file_storage_item_id',
			'courseware_id',
			'status',
			'sort',
		],
	]); ?>


    <hr/>

    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'courseware_to_file_id' => $model->courseware_to_file_id],
	[
		'class' => 'btn btn-danger',
		'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
		'data-method' => 'post',
	]); ?>
    <?php $this->endBlock(); ?>



    <?php echo Tabs::widget(
	[
		'id' => 'relation-tabs',
		'encodeLabels' => false,
		'items' => [
			[
				'label'   => '<b class=""># '.$model->courseware_to_file_id.'</b>',
				'content' => $this->blocks['backend\modules\campus\models\CoursewareToFile'],
				'active'  => true,
			],
		]
	]
);
?>
</div>
