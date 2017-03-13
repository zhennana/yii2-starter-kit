<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', 'Sign In');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sign Ins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->signin_id, 'url' => ['view', 'signin_id' => $model->signin_id]];
$this->params['breadcrumbs'][] = 'View';
?>
<div class="giiant-crud sign-in-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('models', 'Sign In') ?>
        <small>
            <?= $model->signin_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . 'Edit',
            [ 'update', 'signin_id' => $model->signin_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . 'Copy',
            ['create', 'signin_id' => $model->signin_id, 'SignIn'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . 'New',
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . 'Full list', ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\SignIn'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'school_id',
        'grade_id',
        'course_id',
        'student_id',
        'teacher_id',
        'auditor_id',
        'status',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . 'Delete', ['delete', 'signin_id' => $model->signin_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . 'Are you sure to delete this item?' . '',
    'data-method' => 'post',
    ]); ?>
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->signin_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\SignIn'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
