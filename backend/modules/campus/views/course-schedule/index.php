<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \backend\modules\campus\models\CourseSchedule;
use \backend\modules\campus\models\Course;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\CourseSchedule $searchModel
*/
$course  =  new Course;
$this->title = Yii::t('models', '排课管理');
$this->params['breadcrumbs'][] = $this->title;
// var_dump($grade_id);exit;
 $teacher_ids = $course->getlist(2,$grade_id);
 // var_dump($teacher_ids);exit

/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

// if (\Yii::$app->user->can('campus_course-schedule_view', ['route' => true])) {
//     $actionColumnTemplates[] = '{view}';
// }
$visible = false;
if (Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')) {
    $visible = true;
}
if (Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')) {
    $actionColumnTemplates[] = '{update}';
}
   if (Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')) {
     $actionColumnTemplates['button'] = '{button}';
    }

 if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')) {
     $actionColumnTemplates[] = '{delete}';
 }
if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';


// var_dump($actionColumnTemplateString);exit;
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
if(Yii::$app->user->can('manager') || Yii::$app->user->can('E_manager') || Yii::$app->user->can('P_director')){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '批量排课'), ['course/course-batch'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
        <div class="pull-right">
        <?= Html::button('<span class="badge bg-red"></span><i class="fa fa-edit"></i> 批量结束课程',
                [
                    'title'    => '批量结束课程',
                    'class'    => 'btn btn-app opt audit',
                    'disabled' => 'disabled'
                ]
        ); ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options'      => [
                'class' => 'grid-view',
                'style' => 'overflow:auto',
                'id'    => 'grid',
        ],
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
                'update' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                    ];
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                },
                'delete' => function ($url, $model, $key) {
                    $options = [
                        'title' => Yii::t('yii', '删除课程'),
                        'aria-label' => Yii::t('yii', '删除课程'),
                        'data-pjax' => '0',
                       // 'class' => 'btn btn-danger',
                        'data-confirm' => '' . Yii::t('backend', '您确定删除这节课?') . '',
                        'data-method' => 'post',
                    ];
                    if($model->status == 20){
                        return  '';
                    }
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
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
            'class'           => 'yii\grid\CheckboxColumn',
            'name'            => 'id',
            'headerOptions'   =>[
            ],
            'visible'         =>$visible,
            'contentOptions' =>[],
            'checkboxOptions' => function($model, $key, $index, $column){
                if($model->status !=  Course::COURSE_STATUS_OPEN){
                    return ['disabled'=>'disabled'];
                }
                return ['class'=>'select-on-check-one'];
            },
            ],
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
            // [
            //     'attribute'=>'teacher_id',
            //     'label'    => '上课老师',
            //     'value'    =>function($model){
            //         return Yii::$app->user->identity->getUserName($model->teacher_id);
            //     }
            // ],
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'teacher_id',
                'label'    => '上课老师',
                'format'        => 'raw',
                'value'     => function($model){
                    return Yii::$app->user->identity->getUserName($model->teacher_id);
                },
                'enum'      => $teacher_ids
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
                    'template' =>isset($actionColumnTemplates['button'])? $actionColumnTemplates['button'] : '',
                    'buttons'  =>[
                        'button' => function($url,$model,$key){
                            if($model->status !=20 ){
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
<script>
// 手动选择多选框
$(".select-on-check-one").each(function(){
    if($(".select-on-check-one:checked").length < 1){
            $(".opt").attr("disabled", true);
        }
    $(".select-on-check-one").on('click',function(){
        if($(".select-on-check-one:checked").length < 1){
            $(".opt").attr("disabled", true);
            $(".badge").text('');
        }else{
            $(".opt").attr("disabled", false);
            $(".badge").text($(".select-on-check-one:checked").length);
        }
    });
});

// 全选多选框
$(".select-on-check-all").on('click',function(){
    if($(".select-on-check-all:checked").length < 1){
        $(".opt").attr("disabled", true);
        $(".badge").text('');
    }else{
        $(".opt").attr("disabled", false);
        $(".badge").text($(".select-on-check-one").length);
    }
});

// 批量审核
$(document).on('click', '.audit', function (){
    if (confirm('确定结束已勾选的'+$(".select-on-check-one:checked").length+'个结束？审核操作将不可被撤销！')) {
        var ids = $("#grid").yiiGridView("getSelectedRows");
        console.log(ids);
        var data = {"ids":ids};
        $.ajax({
            url:"<?php echo Url::to(['batch-closed']) ?>",
            type:"post",
            datatype:"json",
            data:data,
            success:function(response){
                // console.log(response);
                if(response.code == 200){
                    alert("操作完成！\r\n一共关闭"+response.success_count+"节课");
                    window.location.reload();
                }else if(response.code == 400){
                    alert("操作完成！\r\n一共关闭"+response.success_count+"节课！"+'关闭失败'+response.fail_count);
                    window.location.reload();
                }else{
                    alert("操作失败！\r\n\r\n请确认至少勾选一个签到记录！");
                }
            }
        });
    };
});
</script>