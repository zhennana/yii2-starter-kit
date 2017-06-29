<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Grade $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '班级管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '班级管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->grade_id, 'url' => ['view', 'grade_id' => $model->grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud grade-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '班级管理') ?>
        <small>
            <?= $model->grade_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">
    <?php
        if (\Yii::$app->user->can('P_director', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
    ?>
        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'grade_id' => $model->grade_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'grade_id' => $model->grade_id, 'Grade'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>
        <?php } ?>
    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\Grade'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'school_id',
            'value'     => isset($model->school->school_title) ? $model->school->school_title : '',
        ],
        'grade_name',
        'grade_title',
        [
            'attribute' => 'owner_id',
            'value' =>  Yii::$app->user->identity->getUserName($model->owner_id),
        ],
        //'classroom_group_levels',
        [
            'attribute' => 'status',
            'value'     => backend\modules\campus\models\Grade::getStatusValueLabel($model->status),
        ],
        [
            'attribute' => 'graduate',
            'value'     => backend\modules\campus\models\Grade::getGraduateValue($model->graduate),
        ],
        'time_of_enrollment:datetime',
        'time_of_graduation:datetime',
        [
            'attribute' => 'creater_id',
            'value'     =>  Yii::$app->user->identity->getUserName($model->owner_id),
        ],
        'sort',
    ],
    ]); ?>

    
    <hr/>

  <!--   <? /*Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'grade_id' => $model->grade_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
    'data-method' => 'post',
    ]);*/ ?> -->
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->grade_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\Grade'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
