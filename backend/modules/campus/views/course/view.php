<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use \backend\modules\campus\models\Course;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '课程管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'course_id' => $model->course_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud course-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '课程管理') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?= Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'course_id' => $model->course_id],
            ['class' => 'btn btn-info']) ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'course_id' => $model->course_id, 'Course'=>$copyParams],
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

    <?php $this->beginBlock('backend\modules\campus\models\Course'); ?>

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
            'title',
            'intro',
            [
                'attribute' => 'courseware_id',
                'value'     => function($model){
                    return isset($model->courseware->title) ? $model->courseware->title : '';
                }
            ],
            [
                'attribute' => 'teacher_id',
                'value'     => function($model){
                    return Yii::$app->user->identity->getUserName($model->teacher_id);
                }
            ],
            [
                'attribute' => 'creater_id',
                'value' => function($model){
                    return Yii::$app->user->identity->getUserName($model->creater_id);
                }
            ],
            'start_time:datetime',
            'end_time:datetime',
            [
                'attribute' => 'status',
                'value' => Course::getStatusValueLabel($model->status),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>

    <hr/>

    <!-- <? /* Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'),
        ['delete', 'course_id' => $model->course_id],
        [
            'class'        => 'btn btn-danger',
            'data-confirm' => '' . Yii::t('backend', '确定删除该项目吗？') . '',
            'data-method'  => 'post',
        ]
    );*/ ?> -->

    <?php $this->endBlock(); ?>
    
    <?= Tabs::widget([
        'id'           => 'relation-tabs',
        'encodeLabels' => false,
        'items'        => [
            [
                'label'   => '<b class=""># '.$model->course_id.'</b>',
                'content' => $this->blocks['backend\modules\campus\models\Course'],
                'active'  => true,
            ],
        ]
    ]); ?>
</div>
