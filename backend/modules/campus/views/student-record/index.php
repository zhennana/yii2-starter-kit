<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\StudentRecord;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var common\models\StudentRecordSearch $searchModel
*/

$this->title = Yii::t('models', '学员档案管理');
$this->params['breadcrumbs'][] = $this->title;
/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

     if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{view}';
    }

     if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{update}';
    }
    if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{export}';
    }
/*
    if (\Yii::$app->user->can('P_teacher')) {
        $actionColumnTemplates[] = '{delete}';
    }
*/
    if (isset($actionColumnTemplates)) {

        $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;

    } else {

        Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete} {export}";
    }
?>
<div class="giiant-crud student-record-index">

    <?php //             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '学员档案管理') ?>        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
 if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
        <div class="pull-right">
            <?= \yii\bootstrap\ButtonDropdown::widget(
                [
                    'id' => 'giiant-relations',
                    'encodeLabel' => false,
                    'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', '相关管理'),
                    'dropdown' => [
                        'options' => [
                            'class' => 'dropdown-menu-right'
                        ],
                    'encodeLabels' => false,
                    'items' => []
                    ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
                ]);
            ?>        
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => Yii::t('backend', '首页'),
                'lastPageLabel' => Yii::t('backend', '尾页')        
            ],
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class'=>'x'],
            'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => $actionColumnTemplateString,
                'urlCreator' => function($action, $model, $key, $index) {
                    // using the column name as key, not mapping to 'id' like the standard generator
                    $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                    $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                    return Url::toRoute($params);
                },
                'buttons' => [
                    'export' => function($url, $model, $key){
                        if ($model->getStudentRecordValue()->count()) {
                            $options = [
                                'title'      => Yii::t('yii', '导出Doc文档'),
                                'aria-label' => Yii::t('yii', '导出Doc文档'),
                                // 'target' => '_blank'
                            ];
                            return Html::a('<span class="glyphicon glyphicon-copy"></span>', $url, $options);
                        }
                    }
                ],
                'contentOptions' => ['nowrap'=>'nowrap']
            ],
            [
                'attribute'=>'user_id',
                'value'=>function($model){
                        return Yii::$app->user->identity->getUserName($model->user_id);
                }
            ],
            [
                    'attribute'=>'school_id',
                    'value'=>function($model){
                        return isset($model->school->school_title) ? $model->school->school_title : '';
                    }
                ],
            [
                'attribute'=>'grade_id',
                'value'=>function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name  : '';
                }
            ],
            [
                'attribute'=>'course_id',
                'label'    => '课程标题',
                'value'=>function($model){
                    return isset($model->course->title) ? $model->course->title  : '';
                }
            ],
            'title',
             [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'enum'      => StudentRecord::optsStatus(),
            ],
            [
                'label'=>'上传档案个数',
                'value'=>function($model){
                        return $model->getStudentRecordValue()->count();
                    }
            ],
            'sort',
            'updated_at:datetime',
            'created_at:datetime',
            [
                'label'=>'',
                'format'    => 'raw',
                'value'=>function($model){
                    return Html::a('编写学员档案',['student-record-value/create-value',
                        //'user_id'     => $model->user_id,
                        //'school_id'   => $model->school_id,
                        //'grade_id'    => $model->grade_id,
                        'course_id'     => $model->course_id,
                        'student_record_id'=> $model->student_record_id,
                        'course_schedule_id'=>$model->course_schedule_id,
                    ]);
                }
            ]

        ],
        ]); ?>
    </div>

</div> 
<?php \yii\widgets\Pjax::end() ?>


