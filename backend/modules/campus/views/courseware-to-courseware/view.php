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
use backend\modules\campus\models\CoursewareToCourseware;
/**
 *
 * @var yii\web\View $this
 * @var backend\modules\campus\models\CoursewareToCourseware $model
 */
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '课件关系详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->courseware_to_courseware_id, 'url' => ['view', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud courseware-to-courseware-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?php echo \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?php echo Yii::t('backend', '课件关系详情') ?>
        <small>
            <?php echo $model->courseware_to_courseware_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php echo Html::a(
	'<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
	[ 'update', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id],
	['class' => 'btn btn-info']) ?>

            <!--  <?php // echo Html::a(
	// '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
	// ['create', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id, 'CoursewareToCourseware'=>$copyParams],
	// ['class' => 'btn btn-success']) ?>-->
<!--  
     <?php //echo Html::a(
	// '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'),
	// ['create'],
	// ['class' => 'btn btn-success']) ?> -->
        </div>

        <div class="pull-right">
            <?php echo Html::a('<span class="glyphicon glyphicon-list"></span> '
	. Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\CoursewareToCourseware'); ?>


    <?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			[
	            'attribute'=>'courseware_master_id',
	            'format'    => 'raw',
	            'value'=>function($model){
                	return $model->coursewareMaster->title;
            	}
            ],
            [
                'attribute'=>'courseware_id',
                'format'    => 'raw',
                'value'=>function($model){
                    return $model->courseware->title;
                }
            ],
	       	[
	            'attribute'=>'status',
	            'format'    => 'raw',
	            'value'=>CoursewareToCourseware::LabelStatusValue($model->status)
            ],
            'updated_at:datetime',
            'created_at:datetime'
		],
	]); ?>


    <hr/>

    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'courseware_to_courseware_id' => $model->courseware_to_courseware_id],
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
				'label'   => '<b class=""># '.$model->courseware_to_courseware_id.'</b>',
				'content' => $this->blocks['backend\modules\campus\models\CoursewareToCourseware'],
				'active'  => true,
			],
		]
	]
);
?>
</div>
