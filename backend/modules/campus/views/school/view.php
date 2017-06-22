<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\School $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '学校');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学校'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud school-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '学校') ?>        <small>
            <?= $model->id ?>        </small>
    </h1>
     <?php
        if(\Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')){
    ?>
    <div class="clearfix crud-navigation">
   
        <!-- menu buttons -->
        <div class='pull-left'>
            <?php echo  Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'id' => $model->id],
            ['class' => 'btn btn-info']) 
            ?>

            <?= Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'id' => $model->id, 'School'=>$copyParams],
            ['class' => 'btn btn-success']) ?>

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
<?php  } ?>
    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\School'); ?>

    
    <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
            'id',
        'parent_id',
        'school_id',
        'language',
        'school_title',
        'school_short_title',
        'school_slogan',
        'school_logo_path',
        'school_backgroud_path',
        'longitude',
        'latitude',
        'address',
        'province_id',
        'city_id',
        'region_id',
        'created_at',
        'updated_at',
        'created_id',
        'status',
        'sort',
    ],
    ]); ?>

    
    <hr/>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'id' => $model->id],
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
                     'items' => [ [
    'label'   => '<b class=""># '.$model->id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\School'],
    'active'  => true,
], ]
                 ]
    );
    ?>
</div>
