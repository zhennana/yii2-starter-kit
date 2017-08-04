<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\campus\models\CourseCategory;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\CourseCategory */

$this->title = Yii::t('backend', '课程分类详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '课件详情');
$copyParams = $model->attributes;
?>
<div class="course-category-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '课程分类') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <?php if(Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')){
        ?>
            <div class='pull-left'>
                <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
                [ 'update', 'category_id' => $model->category_id],
                ['class' => 'btn btn-info']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '克隆'),
                ['create', 'category_id' => $model->category_id, 'Courseware'=>$copyParams],
                ['class' => 'btn btn-success']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
                ['create'],
                ['class' => 'btn btn-success']) ?>
            </div>
        <?php  } ?>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>
    <br />
    <hr>
    <br />
    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'category_id',
            'parent_id',
            'name',
            'slug',
            'description',
            'banner_src',
            [
                'attribute' => 'creater_id',
                'value' => function($model){
                    return Yii::$app->user->identity->getUserName($model->creater_id);
                }
            ],
            'updated_at:datetime',
            'created_at:datetime',
            [
                'attribute' => 'status',
                'value'     => CourseCategory::getStatusValueLabel($model->status)
            ],
        ],
    ]) ?>

</div>
