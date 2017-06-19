<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \backend\modules\campus\models\Course;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\CourseSearch $searchModel
*/

$this->title = Yii::t('backend', '课程管理');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('director', ['route' => true])) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('director', ['route' => true])) {
    $actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('director', ['route' => true])) {
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

?>
<div class="giiant-crud course-index">

    <?php // echo $this->render('_search', ['model' =>$searchModel]); ?>


    <?php \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success'=>'function(){alert("yo")}']
    ]) ?>

    <h1>
        <?= Yii::t('backend', '课程管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <?php
            if(\Yii::$app->user->can('manager', ['route' => true])){
        ?>
        <div class="pull-left">
            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '新建'),
                ['create'],
                ['class' => 'btn btn-success']
            ) ?>
        </div>
        <?php } ?>
        <div class="pull-right">

            <?= \yii\bootstrap\ButtonDropdown::widget([
                'id'          => 'giiant-relations',
                'encodeLabel' => false,
                'label'       => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', '相关管理'),
                'dropdown'    => [
                    'options'      => ['class' => 'dropdown-menu-right'],
                    'encodeLabels' => false,
                    'items'        => []
                ],
                'options' => [
                    'class' => 'btn-default'
                ]
            ]); ?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
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
                    'attribute' => 'school_title',
                    'label'     => '学校',
                    'value'     => function($model){
                        return isset($model->school->school_title) ? $model->school->school_title : '';
                    }
                ],
                [
                    'attribute' => 'grade_name',
                    'label'     => '班级',
                    'value'     => function($model){
                        return isset($model->grade->grade_name) ? $model->grade->grade_name  : '';
                    }
                ],
                [
                    'attribute' => 'courseware_title',
                    'label'     => '课件',
                    'value'     => function($model){
                        return isset($model->courseware->title) ?$model->courseware->title  : '';
                    }
                ],
    			'title',
    			'intro',
                [
                    'attribute' => 'creater_id',
                    'label'     => '创建者ID',
                    'value'     => function($model){
                        return isset($model->user->username) ?$model->user->username : '';
                    }
                ],
    			'start_time:datetime',
    			'end_time:datetime',
    			 [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'status',
                    'format'    => 'raw',
                    'enum'      => Course::optsStatus(),
                    'value'     => function($model){
                        return $model->status;
                    },
                ],
    			'updeated_at:datetime',
                'created_at:datetime'
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


