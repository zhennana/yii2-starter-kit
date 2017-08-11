<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \backend\modules\campus\models\SignIn;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\SignIn $searchModel
*/

$this->title = Yii::t('models', '签到管理');
$this->params['breadcrumbs'][] = $this->title;

if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('models', '创建'),
        ['create'],
        ['class' => 'btn btn-success']
    );
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

?>
<div class="giiant-crud sign-in-index">

    <?php // echo $this->render('_search', ['model' =>$searchModel]); ?>

    <?php \yii\widgets\Pjax::begin([
        'id'                 =>'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       =>'#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success'=>'function(){alert("yo")}']
    ]) ?>

    <h1>
        <?= Yii::t('models', '签到管理') ?>
        <small>
            <?= Yii::t('models', '列表') ?>
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?php if (\Yii::$app->user->can('manager')) { ?>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('models', '创建'),
                ['create'],
                ['class' => 'btn btn-success']
            ) ?>
            <?php } ?>
        </div>
        <div class="pull-right">
            <?= Html::button('<span class="badge bg-red"></span><i class="fa fa-edit"></i> 签到审核',
                [
                    'title'    => '签到审核',
                    'class'    => 'btn btn-app opt audit',
                    'disabled' => 'disabled'
                ]
            ); ?>

            <?php /*echo \yii\bootstrap\ButtonDropdown::widget([
                'id'          => 'giiant-relations',
                'encodeLabel' => false,
                'label'       => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('models', '相关管理'),
                'dropdown'    => [
                    'options' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'encodeLabels' => false,
                    'items'        => []
                ],
                'options' => [
                    'class' => 'btn-default'
                ]
            ]); */?>

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
                'class'          => yii\widgets\LinkPager::className(),
                'firstPageLabel' => 'First',
                'lastPageLabel'  => 'Last',
            ],
            'filterModel'      => $searchModel,
            'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
            'headerRowOptions' => ['class'=>'x'],
            'columns'          => [
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => $actionColumnTemplateString,
                    'buttons'  => [
                        'view' => function ($url, $model, $key) {
                            $options = [
                                'title'      => Yii::t('yii', '查看'),
                                'aria-label' => Yii::t('yii', '查看'),
                                'data-pjax'  => '0',
                            ];
                            return Html::a('<span class="glyphicon glyphicon-file"></span>', $url, $options);
                        }
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
                    'class'           => 'yii\grid\CheckboxColumn',
                    'name'            => 'id',
                    'checkboxOptions' => ['class' => 'select-on-check-one'],
                ],
                [
                    'attribute' => 'school_title',
                    'label'     => Yii::t('yii', '学校'),
                    'value'     => function($model){
                        return isset($model->school) ? $model->school->school_title : '(未设置)';
                    }
                ],
                [
                    'attribute' => 'grade_name',
                    'label'     => Yii::t('yii', '班级'),
                    'value'     => function($model){
                        return isset($model->grade) ? $model->grade->grade_name : '(未设置)';
                    }
                ],
                [
                    'attribute' => 'course_title',
                    'label'     => Yii::t('yii', '课程'),
                    'value'     => function($model){
                        return isset($model->course) ? $model->course->title : '(未设置)';
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
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'type_status',
                    'label'     => '签到状态',
                    'enum'      => SignIn::optsTypeStatus(),
                ],
                'describe',
                [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'status',
                    'enum'      => SignIn::optsSignInStatus(),
                    'filter'    => SignIn::optsSignInStatus(),
                ],
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


<script>
<?php $this->beginBlock('Audit') ?>
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
    if (confirm('确定审核已勾选的'+$(".select-on-check-one:checked").length+'个签到记录吗？审核操作将不可被撤销！')) {
        var ids = $("#grid").yiiGridView("getSelectedRows");
        var data = {"ids":ids};
        $.ajax({
            url:"<?php echo Url::to(['sign-in/audit']) ?>",
            type:"post",
            datatype:"json",
            data:data,
            success:function(response){
                // console.log(response);
                if(response.code == 200){
                    alert("操作完成！\r\n审核成功"+response.count+"个签到记录。");
                    window.location.reload();
                }else if(response.code == 400){
                    alert("操作完成！\r\n审核成功"+response.success+"个，审核失败"+response.fail+"个。");
                    window.location.reload();
                }else{
                    alert("操作失败！\r\n\r\n请确认至少勾选一个签到记录！");
                }
            }
        });
    };
});
<?php $this->endBlock() ?>  
<?php $this->registerJs($this->blocks['Audit']); ?> 
</script>
