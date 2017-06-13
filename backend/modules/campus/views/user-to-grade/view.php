<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '学员管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学员管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->user_to_grade_id, 'url' => ['view', 'user_to_grade_id' => $model->user_to_grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud user-to-grade-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '学员管理') ?>
        <small>
            <?= $model->user_to_grade_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">
    <?php
        if(Yii::$app->user->can('director')){
    ?>
        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'user_to_grade_id' => $model->user_to_grade_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'user_to_grade_id' => $model->user_to_grade_id, 'UserToGrade'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'user_to_grade_id' => $model->user_to_grade_id],
                [
                'class' => 'btn btn-danger',
                'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
                'data-method' => 'post',
                ]); ?>
        </div>
    <?php } ?>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\UserToGrade'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'user_id',
            'value'     => isset($model->user->username) ? $model->user->username : '',
        ],
        [
            'attribute' => 'school_id',
            'value'     => isset($model->school->school_title) ?$model->school->school_title : '',
        ],
        [
            'attribute' => 'grade_id',
            'value'     => isset($model->grade->grade_name) ?$model->grade->grade_name : '',
        ],
        'user_title_id_at_grade',
        [
            'attribute' => 'status',
            'value'     => backend\modules\campus\models\UserToGrade::getStatusLabel($model->status),
        ],
        'sort',
        'grade_user_type',
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
    'label'   => '<b class=""># '.$model->user_to_grade_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\UserToGrade'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
