<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

use backend\modules\campus\models\Notice;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\NoticeSearch $searchModel
*/

$this->title = Yii::t('backend', '班级公告');
$this->params['breadcrumbs'][] = $this->title;
    \Yii::$app->session['__crudReturnUrl'] = ['/campus/notice/grade-notice'];

/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_teacher')) {
    //$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_teacher')) {
   //$actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_teacher')) {
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
<div class="giiant-crud notice-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '班级公告') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?php if(\Yii::$app->user->can('campus_notice_create', ['route' => true])){ ?>

            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']) ?>

            <?php } ?>

            <?php echo Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建班级公告'), ['grade-notice-create'], ['class' => 'btn btn-success']) ?>
        </div>
        <div class="pull-right">
            <?= \yii\bootstrap\ButtonDropdown::widget([
                'id'          => 'giiant-relations',
                'encodeLabel' => false,
                'label'       => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', 'Relations'),
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
            'headerRowOptions' => ['class'=>'x'],
            'columns'          => [
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => $actionColumnTemplateString,
                    'buttons'  => [
                        'view' => function ($url, $model, $key) {
                            $options = [
                                'title'      => Yii::t('yii', 'View'),
                                'aria-label' => Yii::t('yii', 'View'),
                                'data-pjax'  => '0',
                            ];
                            return Html::a(
                                '<span class="glyphicon glyphicon-file"></span>',$url, $options
                            );
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
                'notice_id',
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'school_id',
                    'options'   => ['width' => '10%'],
                    'format'    => 'raw',
                    'enum'      => $schools,
                ],
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'grade_id',
                    'options'   => ['width' => '10%'],
                    'format'    => 'raw',
                    'enum'      => $grades,

                ],
                'title',
    
                [
                    'attribute' => 'message',
                    'options'   => ['width' => '50%'],
                    'value'     => function($model){
                        return strip_tags($model->message);
                    }
                ],

                [
                    'attribute' => 'sender_id',
                    'options'   => ['width' => '10%'],
                    'value'     => function($model){
                        return $model->getUserName($model->sender_id);
                    }
                ],
                // [
                //     'attribute' => 'receiver_id',
                //     'options'   => ['width' => '10%'],
                //     'value'     => function($model){
                //         return $model->getUserName($model->receiver_id);
                //     }
                // ],
                //'times',
                // [
                //     'class'     =>\common\grid\EnumColumn::className(),
                //     'attribute' =>'status_send',
                //     'options'   => ['width' => '10%'],
                //     'format'    => 'raw',
                //     'enum'      => Notice::optsStatusSend(),
                //     'value'     => function($model){
                //         return $model->status_send;
                //     },
                // ],
                'updated_at:datetime',
                'created_at:datetime',
                /*'is_sms',*/
                /*'is_wechat_message',*/
                /*'status_check',*/
                /*'title',*/
                /*'message_hash',*/
                /*'receiver_name',*/
                /*'wechat_message_id',*/
                /*'receiver_phone_numeber',*/
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


