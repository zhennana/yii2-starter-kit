<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\CourseOrderItem;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', '课程订单');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '课程订单'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->course_order_item_id, 'url' => ['view', 'course_order_item_id' => $model->course_order_item_id]];
$this->params['breadcrumbs'][] = Yii::t('cruds', '查看');
?>
<div class="giiant-crud course-order-item-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', '课程订单') ?>
        <small>
            <?= $model->course_order_item_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('cruds', '更新'),
            [ 'update', 'course_order_item_id' => $model->course_order_item_id],
            ['class' => 'btn btn-info']) ?>

            <?php  echo Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('cruds', '复制'),
            ['create', 'course_order_item_id' => $model->course_order_item_id, 'CourseOrderItem'=>$copyParams],
            ['class' => 'btn btn-success']) ?>
            <?php 
            if ((\Yii::$app->user->can('P_financial', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) && (env('THEME') == 'edu' || \Yii::$app->user->can('manager'))) { ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
            
            <?php } ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('cruds', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\CourseOrderItem'); ?>

    
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'course_order_item_id',
            [
                'attribute' => 'payment_id',
                'value'     => function($model){
                    return isset($model->payment_id) ? $model->payment_id : '';
                }
            ],
            [
                'attribute' => 'order_sn',
                'value'     => function($model){
                    return isset($model->order_sn) ? $model->order_sn : '';
                }
            ],
            'course_id',
            'parent_id',
            [
                'attribute' =>'school_id',
                'value'     => function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '未知';
                }
            ],
            [
                'attribute' =>'grade_id',
                'value'     => function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name : '未知';
                }
            ],
            [
                'attribute' =>'user_id',
                'value'     => function($model){
                    return Yii::$app->user->identity->getUserName($model->user_id);
                }
            ],
            [
                'attribute' =>'introducer_id',
                'value'     => function($model){
                    return Yii::$app->user->identity->getUserName($model->introducer_id);
                }
            ],
            [
                'attribute' => 'payment',
                'value'     => CourseOrderItem::getPaymentValueLabel($model->payment),
            ],
            [
                'attribute' => 'payment_status',
                'value'     => CourseOrderItem::getPaymentStatusValueLabel($model->payment_status),
            ],
            'total_course',
            'presented_course',
            'total_price',
            'coupon_price',
            'coupon_type',
            'real_price',
            [
                'attribute' => 'status',
                'value'     => CourseOrderItem::getStatusValueLabel($model->status),
            ],
        ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('cruds', '删除'), ['delete', 'course_order_item_id' => $model->course_order_item_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('cruds', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget([
        'id'           => 'relation-tabs',
        'encodeLabels' => false,
        'items'        => [[
            'label'   => '<b class=""># '.$model->course_order_item_id.'</b>',
            'content' => $this->blocks['backend\modules\campus\models\CourseOrderItem'],
            'active'  => true,
        ],]
    ]); ?>
</div>
