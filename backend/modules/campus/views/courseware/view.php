<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Courseware $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', 'Courseware');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'courseware_id' => $model->courseware_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud courseware-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '课件') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', 'Edit'),
            [ 'update', 'courseware_id' => $model->courseware_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', 'Copy'),
            ['create', 'courseware_id' => $model->courseware_id, 'Courseware'=>$copyParams],
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

    <?php $this->beginBlock('backend\modules\campus\models\Courseware'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        'body:ntext',
        'category_id',
        'creater_id',
        'parent_id',
        'access_domain',
        'access_other',
        'status',
        'tags',
        'level',

        
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'courseware_id' => $model->courseware_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
            [
            'label'   => '<b class="">课件ID # '.$model->courseware_id.'</b>',
            'content' => $this->blocks['backend\modules\campus\models\Courseware'],
            'active'  => true,
            ],
            [
            'label'   => '<b class="">附件</b>',
            'content' => $this->blocks['backend\modules\campus\models\Courseware'],
            'active'  => false,
            ],
            [
            'label'   => '<b class="">关联课程</b>',
            'content' => $this->blocks['backend\modules\campus\models\Courseware'],
            'active'  => false,
            ],
        ]
    ]);
    ?>
</div>
