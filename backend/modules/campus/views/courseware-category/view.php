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
 * @var backend\modules\campus\models\CoursewareCategory $model
 */
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '分类详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud courseware-category-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?php echo \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?php echo Yii::t('backend', '课件分类') ?>
        <small>
            <?php echo $model->name ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?php echo Html::a(
	'<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
	[ 'update', 'category_id' => $model->category_id],
	['class' => 'btn btn-info']) ?>

            <?php echo Html::a(
	'<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
	['create', 'category_id' => $model->category_id, 'CoursewareCategory'=>$copyParams],
	['class' => 'btn btn-success']) ?>

            <?php echo Html::a(
	'<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
	['create'],
	['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?php echo Html::a('<span class="glyphicon glyphicon-list"></span> '
	. Yii::t('backend', '返回'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\CoursewareCategory'); ?>


    <?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'parent_id',
			[
				'attribute'=>'creater_id',
				'value'=>isset($model->user->username)? $model->user->username : '',
			],
			'name',
			'description',
			[
				'attribute'=>'banner_src',
				 'format'    => 'raw',
				'label'	=>'图片',
				'value'=>function($model){
                    return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$model->banner_src.'?imageView2/1/w/50/h/50" />', $model->banner_src.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
					
				}
			],
			[
				'attribute'=>'status',
				'value'=>\backend\modules\campus\models\CoursewareCategory::StatusValueLabel($model->status)
			],
		],
	]); ?>


    <hr/>

    <?php echo Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'category_id' => $model->category_id],
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
				'label'   => '<b class=""># '.$model->category_id.'</b>',
				'content' => $this->blocks['backend\modules\campus\models\CoursewareCategory'],
				'active'  => true,
			],
		]
	]
);
?>
</div>
