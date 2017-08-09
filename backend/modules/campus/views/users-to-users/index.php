<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\UsersToUsers;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\UsersToUsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '账号关系管理');
$this->params['breadcrumbs'][] = $this->title;


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
if (\Yii::$app->user->can('P_director', ['route' => true]) || 
    \Yii::$app->user->can('E_manager') ||
    \Yii::$app->user->can('manager')
    ) {
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

<div class="users-to-users-index">
    <?php \yii\widgets\Pjax::begin([
        'id'                 => 'pjax-main',
        'enableReplaceState' => false,
        'linkSelector'       => '#pjax-main ul.pagination a, th a',
        'clientOptions'      => ['pjax:success'=>'function(){alert("yo")}']
    ]) ?>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'     => ['class' => 'table table-striped table-bordered table-hover'],
        'headerRowOptions' => ['class' => 'x'],
        'pager'            => [
            'class'          => yii\widgets\LinkPager::className(),
            'firstPageLabel' => Yii::t('backend', '首页'),
            'lastPageLabel'  => Yii::t('backend', '尾页'),
        ],
        'columns' => [
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

            'users_to_users_id',
            [
                'attribute' => 'user_left_id',
                'value' => function($model){
                    return UsersToUsers::getUserName($model->user_left_id);
                }
            ],
            [
                'attribute' => 'user_right_id',
                'value' => function($model){
                    return UsersToUsers::getUserName($model->user_right_id);
                }
            ],
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'type',
                'format'    => 'raw',
                'enum'      => UsersToUsers::optsType(),
                'value'     => function($model){
                    return $model->type;
                },
            ],
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'format'    => 'raw',
                'enum'      => UsersToUsers::optsStatus(),
                'value'     => function($model){
                    return $model->status;
                },
            ],

        ],
    ]); ?>

</div>
<?php \yii\widgets\Pjax::end() ?>
