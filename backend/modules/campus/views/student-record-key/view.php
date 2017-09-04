<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\StudentRecordKey;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordKey $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '科目标题');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '科目标题'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_key_id' => $model->student_record_key_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'View');
?>
<div class="giiant-crud student-record-key-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '科目标题') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>


    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
            <?=  Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'student_record_key_id' => $model->student_record_key_id],
            ['class' => 'btn btn-info'])  ?>

            <?=  Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'student_record_key_id' => $model->student_record_key_id, 'StudentRecordKey'=>$copyParams],
            ['class' => 'btn btn-success'])  ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']) ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\StudentRecordKey'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        [
            'attribute' => 'school_id',
            'value' => function($model){
                return isset($model->school) ? $model->school->school_title : '全局标题';
            }
        ],
        [
            'attribute' => 'grade_id',
            'value' => function($model){
                return isset($model->grade) ? $model->grade->grade_name : '全局标题';
            }
        ],
        [
            'attribute' => 'status',
            'value' => function($model){
                return StudentRecordKey::getStatusLabel($model->status);
            }
        ],
        'sort',
    ],
    ]); ?>

    
    <hr/>

    <!--<?php /* Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', 'Delete'), ['delete', 'student_record_key_id' => $model->student_record_key_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', 'Are you sure to delete this item?') . '',
    'data-method' => 'post',
    ]); */ ?>-->
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->student_record_key_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\StudentRecordKey'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
