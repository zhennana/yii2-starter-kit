<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;


use backend\modules\campus\models\Notice;

Modal::begin([
    'options' => [
        'id' => 'update-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'id' => 'update-modal',
    'header' => '<h4 class="modal-title">回复问题</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);
Modal::end();
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\NoticeSearch $searchModel
*/
 //\Yii::$app->session['__crudReturnUrl'] = ['/campus/notice/school-notice'];
$this->title = Yii::t('backend', '消息反馈');
$this->params['breadcrumbs'][] = $this->title;

/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_director')) {
    //$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_director')){
    //$actionColumnTemplates[] = '{update}';
}

if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')
|| \Yii::$app->user->can('P_director')){
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
<div class="giiant-crud notice-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '反馈意见') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
        <div class="pull-left">


            <?php 
                // if (\Yii::$app->user->can('E_manager', ['route' => true]) || \Yii::$app->user->can('manager')|| \Yii::$app->user->can('P_director')){
                //     echo  Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建学校公告'), ['school-notice-create'], ['class' => 'btn btn-success']) ;
                // }
             ?>
        </div>
        <div class="pull-right">
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
               /* [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'school_id',
                    'options'   => ['width' => '10%'],
                    'format'    => 'raw',
                    'enum'      => $schools,
                    'value'     => function($model){
                        return $model->status_send;
                    },
                ],*/
                //'title',
                [
                    'attribute' => 'sender_id',
                    'label'     => '提问者',
                    'options'   => ['width' => '10%'],
                    'value'     => function($model){
                        return $model->getUserName($model->sender_id);
                    }
                ],
                [
                    'attribute' => 'message',
                    'label'     => '问题',
                    'options'   => ['width' => '20%'],
                    'value'     => function($model){
                        return strip_tags($model->message);
                    }
                ],
                [
                    'attribute'=>'回复内容',
                    'label'    =>'回复内容',
                    'value'    =>function($model){
                        return isset($model->reply->message) ? $model->reply->message : '';
                    }
                ],
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'status_check',
                    'options'   => ['width' => '10%'],
                    'format'    => 'raw',
                    'enum'      => Notice::optsStatusCheck(),
                ],

                // [
                //     'attribute' => 'receiver_id',
                //     'options'   => ['width' => '10%'],
                //     'value'     => function($model){
                //         return $model->getUserName($model->receiver_id);
                //     }
                // ],
                //'times',
                /*
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'status_send',
                    'options'   => ['width' => '10%'],
                    'format'    => 'raw',
                    'enum'      => Notice::optsStatusSend(),
                    'value'     => function($model){
                        return $model->status_send;
                    },
                ],
                */
                'updated_at:datetime',
                'created_at:datetime',
                [
                    'label'=>'操作',
                    'format'    => 'raw',
                    'value'=>function($modle){
                        return Html::a('回复','#',[
                            'data-toggle' => 'modal',
                            'data-target' => '#update-modal',
                            'class'       => 'data-update',
                        ]);
                    }
                ],
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
<?php
$requestUpdateUrl = Url::toRoute('reply');
$updateJs = <<<JS
    $('.data-update').on('click', function () {
        $.get('{$requestUpdateUrl}', { notice_id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($updateJs);

?>
