<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\GradeCategory;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\GradeCategory $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '班级分类管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '班级分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'grade_category_id' => $model->grade_category_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud grade-categroy-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '班级分类管理') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">
    <?php
        if(Yii::$app->user->can('manager')){
    ?>
        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'grade_category_id' => $model->grade_category_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'grade_category_id' => $model->grade_category_id, 'GradeCategroy'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'grade_category_id' => $model->grade_category_id],
                [
                'class' => 'btn btn-danger',
                'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
                'data-method' => 'post',
                ]); ?>
        </div>
    <?php }?>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\GradeCategroy'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'parent_id',
        [
            'attribute' => 'creater_id',
            'value'     => GradeCategory::getUserName($model->creater_id),
        ],
        [
            'attribute' => 'status',
            'value'     => $model->getStatusLabel($model->status),
        ],
        'name',
    ],
    ]); ?>

    
    <hr/>


    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->grade_category_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\GradeCategroy'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
