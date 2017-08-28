<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\WorkRecord;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\WorkRecordSearch $searchModel
*/

$this->title = Yii::t('models', '老师工作记录');
$this->params['breadcrumbs'][] = $this->title;
/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

// if (\Yii::$app->user->can('campus_work-record_view', ['route' => true])) {
//     $actionColumnTemplates[] = '{view}';
// }

if (\Yii::$app->user->can('manager', ['route' => true])   || 
    \Yii::$app->user->can('E_manager', ['route' => true]) ||
    \Yii::$app->user->can('P_director', ['route' => true])
    ) {
    $actionColumnTemplates[] = '{update}';
}

// if (\Yii::$app->user->can('campus_work-record_delete', ['route' => true])) {
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
<div class="giiant-crud work-record-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', '教师工作记录') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('campus_work-record_create', ['route' => true])){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
        <div class="pull-right">
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
            [
                'attribute'=>'user_id',
                'label'    => '教师',
                'value'    =>function($model){
                    return Yii::$app->user->identity->getUserName($model->user_id);
                }
            ],
            // [
            //     'class'=>\common\grid\EnumColumn::className(),
            //     'attribute' =>'school_id',
            //     'label'     =>'学校',
            //     'enum'      => WorkRecord::optsStatus(),
            // ],
            // [
            //     'class'=>\common\grid\EnumColumn::className(),
            //     'attribute' =>'grade_id',
            //     'label'     =>'班级33',
            //     'enum'      => WorkRecord::optsStatus(),
            // ],
			[
            'attribute'=>'title',
            'label'=>'上课内容'
            ],
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'label'     =>'状态',
                'enum'      => WorkRecord::optsStatus(),
            ],
            'updated_at:datetime',
            'created_at:datetime'
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


