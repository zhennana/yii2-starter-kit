<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Contact $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('common', 'Contact');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Contacts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->contact_id, 'url' => ['view', 'contact_id' => $model->contact_id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'View');
?>
<div class="giiant-crud contact-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('common', 'Contact') ?>
        <small>
            <?= $model->contact_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('common', 'Edit'),
            [ 'update', 'contact_id' => $model->contact_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('common', 'Copy'),
            ['create', 'contact_id' => $model->contact_id, 'Contact'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', 'New'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('common', 'Full list'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\Contact'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'username',
        'phone_number',
        'body',
        'auditor_id',
        'status',
        'email:email',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('common', 'Delete'), ['delete', 'contact_id' => $model->contact_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('common', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->contact_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\Contact'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
