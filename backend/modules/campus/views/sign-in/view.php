<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use \backend\modules\campus\models\SignIn;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('models', '签到管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '签到管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->signin_id, 'url' => ['view', 'signin_id' => $model->signin_id]];
$this->params['breadcrumbs'][] = Yii::t('models', '查看');
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
        <?= Yii::t('models', '签到管理') ?>
        <small>
            <?= $model->signin_id ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('models', '更新'),
            [ 'update', 'signin_id' => $model->signin_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('models', '复制'),
            ['create', 'signin_id' => $model->signin_id, 'SignIn'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('models', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('models', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\SignIn'); ?>

    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            [
                'attribute' => 'school_id',
                'value'     => function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
            [
                'attribute' => 'grade_id',
                'value'     => function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name : '';
                }
            ],
            [
                'attribute' => 'course_id',
                'value'     => function($model){
                    return isset($model->course->title) ? $model->course->title : '';
                }
            ],
            [
                'attribute' => 'student_id',
                'value'     => function($model){
                    return SignIn::getUserName($model->student_id);
                }
            ],
            [
                'attribute' => 'teacher_id',
                'value'     => function($model){
                    return SignIn::getUserName($model->teacher_id);
                }
            ],
            [
                'attribute' => 'auditor_id',
                'value'     => function($model){
                    return SignIn::getUserName($model->auditor_id);
                }
            ],
            [
                'attribute' => 'status',
                'value' => $model->getSignInStatusLabel($model->status),
            ],
        ],
    ]); ?>

    <hr/>

    <?= Html::a(
        '<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('models', '删除'),
        ['delete', 'signin_id' => $model->signin_id],
        [
            'class'        => 'btn btn-danger',
            'data-confirm' => '' . Yii::t('models', '确定要删除吗？') . '',
            'data-method'  => 'post',
        ]
    ); ?>

    <?php $this->endBlock(); ?>

    <?= Tabs::widget([
        'id'           => 'relation-tabs',
        'encodeLabels' => false,
        'items'        => [
            [
                'label'   => '<b class=""># '.$model->signin_id.'</b>',
                'content' => $this->blocks['backend\modules\campus\models\SignIn'],
                'active'  => true,
            ],
        ]
     ]); ?>

</div>

