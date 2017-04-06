<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\FileStorageItem $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', 'File Storage Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'File Storage Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->file_storage_item_id, 'url' => ['view', 'file_storage_item_id' => $model->file_storage_item_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud file-storage-item-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', 'File Storage Item') ?>
        <small>
            <?= $model->file_storage_item_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
            [ 'update', 'file_storage_item_id' => $model->file_storage_item_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
            ['create', 'file_storage_item_id' => $model->file_storage_item_id, 'FileStorageItem'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\FileStorageItem'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'user_id',
        'school_id',
        'grade_id',
        'file_category_id',
        'size',
        'ispublic',
        'status',
        'page_view',
        'sort_rank',
        'url:url',
        'type',
        'component',
        'file_name',
        'upload_ip',
        'original',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'file_storage_item_id' => $model->file_storage_item_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->file_storage_item_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\FileStorageItem'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
