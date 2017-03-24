<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\GradeCategroy $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Grade Categroy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Grade Categroys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'grade_category_id' => $model->grade_category_id]];
$this->params['breadcrumbs'][] = Yii::t('cruds', 'View');
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
        <?= Yii::t('models', 'Grade Categroy') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('cruds', 'Edit'),
            [ 'update', 'grade_category_id' => $model->grade_category_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('cruds', 'Copy'),
            ['create', 'grade_category_id' => $model->grade_category_id, 'GradeCategroy'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', 'New'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('cruds', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\GradeCategroy'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'parent_id',
        'creater_id',
        'status',
        'name',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('cruds', 'Delete'), ['delete', 'grade_category_id' => $model->grade_category_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('cruds', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
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
