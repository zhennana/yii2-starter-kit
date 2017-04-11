<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ApplyToPlay $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '预约信息');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '预约信息'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->apply_to_play_id, 'url' => ['view', 'apply_to_play_id' => $model->apply_to_play_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud apply-to-play-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '预约信息') ?>
        <small>
            <?= $model->apply_to_play_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'apply_to_play_id' => $model->apply_to_play_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'apply_to_play_id' => $model->apply_to_play_id, 'ApplyToPlay'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '新建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\ApplyToPlay'); ?>

    
    <?= DetailView::widget([
    'model'      => $model,
    'attributes' => [
        'username',
        'age',
        'phone_number',
        'province_id',
        'school_id',
        'auditor_id',
        'status',
        'created_at:datetime',
        'updated_at:datetime',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'apply_to_play_id' => $model->apply_to_play_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->apply_to_play_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\ApplyToPlay'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
