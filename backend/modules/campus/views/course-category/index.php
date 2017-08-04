<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\CourseCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\CourseCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '课程分类管理');
$this->params['breadcrumbs'][] = $this->title;

$parents = \backend\modules\campus\models\CourseCategory::find()->where(['parent_id'=>0])->all();
$parents = \yii\helpers\ArrayHelper::map(
    $parents, 'category_id', 'name'
);

/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('P_teacher', ['route' => true])|| \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('P_director', ['route' => true]) || 
    \Yii::$app->user->can('E_manager') ||
    \Yii::$app->user->can('manager')
    ) {
    $actionColumnTemplates[] = '{update}';
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
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

?>

<div class="course-category-index">

    <?php \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success'=>'function(){alert("yo")}']
    ]) ?>

    <h1>
        <?= Yii::t('backend', '课程分类管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <?php
           if (\Yii::$app->user->can('P_director', ['route' => true]) || 
                \Yii::$app->user->can('E_manager') ||
                \Yii::$app->user->can('manager')
                ) {
        ?>
        <div class="pull-left">
            <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
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




    <?php echo GridView::widget([
        'dataProvider'     => $dataProvider,
        'filterModel'      => $searchModel,
        'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class' => 'x'],
        'pager'            => [
            'class'          => yii\widgets\LinkPager::className(),
            'firstPageLabel' => Yii::t('backend', '首页'),
            'lastPageLabel'  => Yii::t('backend', '尾页'),
        ],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
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
                'attribute' => 'category_id',
                'options' => ['width' => '10%'],
            ],
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'options' => ['width' => '10%'],
                'attribute' =>'parent_id',
                'format'        => 'raw',
                'enum'      => $parents
            ],
            'name',
            'slug',
            // 'description',
            // 'banner_src',
            [
                'attribute' => 'creater_id',
                'value' => function($model){
                    return Yii::$app->user->identity->getUserName($model->creater_id);
                }
            ],
            // 'updated_at',
            // 'created_at',
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'format'    => 'raw',
                'enum'      => CourseCategory::optsStatus(),
                'value'     => function($model){
                    return $model->status;
                },
            ],
            'updated_at:datetime',
            // 'created_at:datetime'

        ],
    ]); ?>

</div>
<?php \yii\widgets\Pjax::end() ?>