<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordTitle $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', 'Student Record Title');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_title_id' => $model->student_record_title_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud student-record-title-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', 'Student Record Title') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
            [ 'update', 'student_record_title_id' => $model->student_record_title_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
            ['create', 'student_record_title_id' => $model->student_record_title_id, 'StudentRecordTitle'=>$copyParams],
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

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecordTitle'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'title',
        'status',
        'sort',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'student_record_title_id' => $model->student_record_title_id],
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
    'label'   => '<b class=""># '.$model->student_record_title_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\StudentRecordTitle'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
