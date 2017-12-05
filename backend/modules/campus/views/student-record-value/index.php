<?php

// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\modules\campus\models\StudentRecordKey;
use backend\modules\campus\models\StudentRecordValue;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\StudentRecordValueSearch $searchModel
*/

$this->title = Yii::t('backend', '成绩管理');
$this->params['breadcrumbs'][] = $this->title;
$keys = StudentRecordKey::find()->where(['status'=>StudentRecordKey::STUDENT_KEY_STATUS_OPEN])->all();
$keys = ArrayHelper::map($keys,'student_record_key_id','title');

$schools = Yii::$app->user->identity->schoolsInfo;
$grades =  Yii::$app->user->identity->gradesInfo;
$schools = ArrayHelper::map($schools,'school_id','school_title');
$grades  = ArrayHelper::map($grades,'grade_id','grade_name');

/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('P_teacher') || Yii::$app->user->can('E_manager')) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('P_teacher') || Yii::$app->user->can('E_manager')) {
    $actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('manager', ['route' => true])) {
    // $actionColumnTemplates[] = '{delete}';
}
if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud student-record-value-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '成绩管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('P_teacher') || Yii::$app->user->can('E_manager')){
?>
        <div class="pull-left" style="margin-right:  2px">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>

         <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '批量创建'), ['batch-create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?php } ?>
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
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'school_id',
                'enum'      => $schools,
            ],
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'grade_id',
                'enum'      => $grades,
            ],
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' => 'student_record_key_id',
                'label' => '科目标题',
                'enum' => $keys,
                'value' => function($model){
                    if (isset($model->studentRecordKey) && !empty($model->studentRecordKey->title)) {
                        return $model->studentRecordKey->title;
                    }
                    return '无标题';
                }
            ],
            [
                'attribute' =>'user_id',
                'label'     => '姓名',
                'format'    => 'raw',
                'value'     => function($model){
                        return  Html::a('[id'.$model->user_id.']-'.Yii::$app->user->identity->getUserName($model->user_id),[
                            'user-to-school/account',
                            'user_id'=>$model->user_id
                            ]);
                    }
            ],
            'total_score',
            'score',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'exam_type',
                'enum'      => StudentRecordValue::optsExamType(),
            ],
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'enum'      => StudentRecordValue::optsStatus(),
            ],
			'sort',
        ],
        ]); ?>
    </div>

</div>
<?php \yii\widgets\Pjax::end() ?>


