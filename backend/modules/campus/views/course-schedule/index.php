<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \backend\modules\campus\models\CourseSchedule;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\CourseSchedule $searchModel
*/

$this->title = Yii::t('models', 'Course Schedules');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

// if (\Yii::$app->user->can('campus_course-schedule_view', ['route' => true])) {
//     $actionColumnTemplates[] = '{view}';
// }

// if (\Yii::$app->user->can('campus_course-schedule_update', ['route' => true])) {
//     $actionColumnTemplates[] = '{update}';
// }

// if (\Yii::$app->user->can('campus_course-schedule_delete', ['route' => true])) {
//     $actionColumnTemplates[] = '{delete}';
// }
if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud course-schedule-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', '课程排课') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('user', ['route' => true])){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '批量排课'), ['course/course-batch'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
        <div class="pull-right">

            <?= 
            \yii\bootstrap\ButtonDropdown::widget(
            [
            'id' => 'giiant-relations',
            'encodeLabel' => false,
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', 'Relations'),
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [

]
            ],
            'options' => [
            'class' => 'btn-default'
            ]
            ]
            );
            ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
        'class' => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', 'First'),
        'lastPageLabel' => Yii::t('backend', 'Last'),
        ],
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class'=>'x'],
        'columns' => [
                [
            'class' => 'yii\grid\ActionColumn',
            'template' => $actionColumnTemplateString,
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                }
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ],
			//'course_id',
            [
                'attribute'=>'title',
                'label'    => '课程名',
                'format'   =>'raw',
                'value'    =>function($model){
                    return Html::a($model->course->title,['courseware/view','courseware_id'=> $model->course->courseware_id]);
                }
            ],
            [
                'attribute'=>'school_id',
                'label'    => '学校',
                'value'    =>function($model){
                    return isset($model->course->school->school_title) ? $model->course->school->school_title  : '';
                }
            ],
            [
                'attribute'=>'grade_id',
                'label'    => '班级',
                'value'    =>function($model){
                    return isset($model->course->grade->grade_name) ? $model->course->grade->grade_name : '';
                }
            ],
            [
                'attribute'=>'teacher_id',
                'label'    => '上课老师',
                'value'    =>function($model){
                    return Yii::$app->user->identity->getUserName($model->teacher_id);
                }
            ],
            'which_day',
			'start_time',
			'end_time',
			//'status',
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'format'        => 'raw',
                'value'     => function($model){
                    return $model->status;
                },
                'enum'      => CourseSchedule::optsStatus()
            ],
            [
                    'class'    =>'yii\grid\ActionColumn',
                    'header'   =>'排课时间对调',
                    'template' =>'{button}',
                    'buttons'  =>[
                        'button' => function($url,$model,$key){
                            if($model->status !=20){
                                return Html::a('时间排课',
                                    ['time-switch',
                                    'grade_id'  => $model->course->grade_id,
                                    'school_id' => $model->course->school_id,
                                    'course_schedule_id' => $model->course_schedule_id,
                                    'course_id'          => $model->course_id,
                                    ],
                                    [
                                    'class'=>'btn btn-danger audit',
                                    'title'=>'排课时间对换',
                                    ]);
                            }else{
                               return  Html::button('课程已结束', [
                                    'class' => 'btn btn-default disabled',
                                ]); 
                            }
                        }
                    ]
            ]
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>