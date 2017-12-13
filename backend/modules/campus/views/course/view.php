<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use \backend\modules\campus\models\Course;
use backend\modules\campus\models\search\CourseSearch;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '课程管理');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'course_id' => $model->course_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('P_teacher', ['route' => true])|| \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
    $actionColumnTemplates[] = '{view}';
}

if ((\Yii::$app->user->can('P_director', ['route' => true]) || 
    \Yii::$app->user->can('E_manager') ||
    \Yii::$app->user->can('manager')
    ) || env('THEME') == 'edu') {
    $actionColumnTemplates[] = '{update}';
}
if (env('THEME') == 'gedu' || \Yii::$app->user->can('manager')) {
 $actionColumnTemplates[] = '{update-course}';
}
if (\Yii::$app->user->can('P_director', ['route' => true]) || 
    \Yii::$app->user->can('E_manager') ||
    \Yii::$app->user->can('manager')
    ) {
    //$actionColumnTemplates[] = '{delete}';
}
if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete} {update-course}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

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
            <?php 
            /* 
            echo Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'course_id' => $model->course_id],
            ['class' => 'btn btn-info']) 
            */
            ?>

            <?php 
            /*
            echo Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '复制'),
            ['create', 'course_id' => $model->course_id, 'Course'=>$copyParams],
            ['class' => 'btn btn-success']) 
            */
            ?>

            <?php
            /* 
            echo Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '新建'),
            ['create'],
            ['class' => 'btn btn-success'])
            */
            ?>
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\Course'); ?>

    <?php if (env('THEME') == 'gedu') {
        echo DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'course_id',
                'parent_id',
                [
                    'attribute' => 'parent_id',
                    'label' => '父课程',
                    'value' => function($model){
                        return $model->parent_id;
                    }
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function($model){
                        return isset($model->courseCategory->name) ? $model->courseCategory->name : '';
                    }
                ],
                [
                    'attribute' => 'school_id',
                    'value'     => function($model){
                        return isset($model->school->school_title) ? $model->school->school_title : '';
                    }
                ],
                /*[
                    'attribute' => 'grade_id',
                    'value'     => function($model){
                        return isset($model->grade->grade_name) ? $model->grade->grade_name : '';
                    }
                ],*/
                'title',
                'intro',
                'banner_src',
                [
                    'attribute' => 'courseware_id',
                    'value'     => function($model){
                        return isset($model->courseware->title) ? $model->courseware->title : '';
                    }
                ],
                'original_price',
                'present_price',
                'vip_price',
                [
                    'attribute' => 'access_domain',
                    'value' => Course::getPriceValueLabel($model->access_domain),
                ],
                /*[
                    'attribute' => 'teacher_id',
                    'value'     => function($model){
                        return Yii::$app->user->identity->getUserName($model->teacher_id);
                    }
                ],*/
                [
                    'attribute' => 'creater_id',
                    'value' => function($model){
                        return Yii::$app->user->identity->getUserName($model->creater_id);
                    }
                ],
                /*'start_time:datetime',
                'end_time:datetime',*/
                [
                    'attribute' => 'status',
                    'value' => Course::getStatusValueLabel($model->status),
                ],
                'course_counts',
                'sort',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);

    } ?>

    <?php  
        if (env('THEME') == 'edu') {
            echo DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'course_id',
                // 'parent_id',
                /*[
                    'attribute' => 'parent_id',
                    'label' => '父课程',
                    'value' => function($model){
                        return $model->parent_id;
                    }
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function($model){
                        return isset($model->courseCategory->name) ? $model->courseCategory->name : '';
                    }
                ],*/
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
                // 'banner_src',
                [
                    'attribute' => 'courseware_id',
                    'value'     => function($model){
                        return isset($model->courseware->title) ? $model->courseware->title : '';
                    }
                ],
                // 'original_price',
                // 'present_price',
                // 'vip_price',
                /*[
                    'attribute' => 'access_domain',
                    'value' => Course::getPriceValueLabel($model->access_domain),
                ],*/
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
                // 'course_counts',
                // 'sort',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]);
        }
    ?>

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

    <?php $this->beginBlock('ParentCourse'); ?>

    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager'        => [
                'class'          => yii\widgets\LinkPager::className(),
                'firstPageLabel' => Yii::t('backend', '首页'),
                'lastPageLabel'  => Yii::t('backend', '尾页'),
            ],
            'filterModel'      => $searchModel,
            'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class' => 'x'],
            'columns'          => [
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => $actionColumnTemplateString,
                    'buttons'  => [
                        'view' => function ($url, $model, $key) {
                            $options = [
                                'title'      => Yii::t('backend', '查看'),
                                'aria-label' => Yii::t('backend', '查看'),
                                'data-pjax'  => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                        },
                        'update' => function ($url, $model, $key) {
                            $options = [
                                'title'      => Yii::t('backend', '更新排课'),
                                'aria-label' => Yii::t('backend', '更新排课'),
                                'data-pjax'  => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                        },
                        'update-course' => function ($url, $model, $key) {
                            $options = [
                                'title'      => Yii::t('backend', '更新课程'),
                                'aria-label' => Yii::t('backend', '更新课程'),
                                'data-pjax'  => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-wrench"></span>', $url, $options);
                        },
                    ],
                    'urlCreator' => function($action, $model, $key, $index) {
                        // using the column name as key, not mapping to 'id' like the standard generator
                        $params    = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                        $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                        return Url::toRoute($params);
                    },
                    'contentOptions' => ['nowrap'=>'nowrap']
                ],
                [
                    'attribute' => 'school_title',
                    'label'     => '学校',
                    'options' => ['width' => '10%'],
                    'value'     => function($model){
                        return isset($model->school->school_title) ? $model->school->school_title : '';
                    }
                ],
                // [
                //     'attribute' => 'grade_name',
                //     'label'     => '班级',
                //     'options' => ['width' => '8%'],
                //     'value'     => function($model){
                //         return isset($model->grade->grade_name) ? $model->grade->grade_name  : '';
                //     }
                // ],
                [
                    'attribute' => 'courseware_title',
                    'label'     => '课件',
                     'format'    => 'raw',
                    'value'     => function($model){
                        if(isset($model->courseware->title)){
                            return Html::a($model->courseware->title,[
                                        '/campus/courseware/view','courseware_id'=>$model->courseware_id
                                ]);
                        }else{
                            return '';
                        }
                      //  return isset($model->courseware->title) ?$model->courseware->title  : '';
                    }
                ],
                'title',
                'intro',
                /*
                [
                    'attribute' => 'teacher_id',
                    'label'     => '上课老师',
                    'value'     => function($model){
                        return Yii::$app->user->identity->getUserName($model->teacher_id);
                    }
                ],
                */
                // 'start_time:datetime',
                // 'end_time:datetime',
                 [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'status',
                    'format'    => 'raw',
                    'enum'      => Course::optsStatus(),
                    'value'     => function($model){
                        return $model->status;
                    },
                ],
                'updated_at:datetime',
                'created_at:datetime'
            ]
        ]); ?>

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
            [
                'label'   => $is_parent ? '父课程' : '子课程',
                'content' => $this->blocks['ParentCourse'],
                'active'  => false,
            ],
        ]
    ]); ?>
</div>
