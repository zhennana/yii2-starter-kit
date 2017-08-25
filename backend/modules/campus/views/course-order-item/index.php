<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\CourseOrderItem;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\CourseOrderItemSearch $searchModel
*/

$this->title = Yii::t('models', '课程订单');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('P_financial', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
    $actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('P_financial', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
    $actionColumnTemplates[] = '{update}';
}

// if (\Yii::$app->user->can('P_director', ['route' => true])) {
//     $actionColumnTemplates[] = '{delete}';
// }
if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud course-order-item-index">

    <?php // echo $this->render('_search', ['model' =>$searchModel]); ?>

    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('models', '课程订单') ?>
        <small>
            列表
        </small>
    </h1>

    <div class="clearfix crud-navigation">

        <?php 
            if ((\Yii::$app->user->can('P_financial', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) && (env('THEME') == 'edu' || \Yii::$app->user->can('manager'))) { ?>
            <div class="pull-left">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        <?php } ?>

        <div class="pull-right">

            <?= \yii\bootstrap\ButtonDropdown::widget([
                'id'          => 'giiant-relations',
                'encodeLabel' => false,
                'label'       => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('cruds', 'Relations'),
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
                'firstPageLabel' => Yii::t('cruds', '首页'),
                'lastPageLabel'  => Yii::t('cruds', '尾页'),
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
                    'attribute' => 'course_order_item_id',
                    'options'   => ['width' => '6%'],
                ],
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'enum'      => $schools,
                    'attribute' =>'school_id',
                    'format'    => 'raw',
                    'options'   => ['width' => '10%'],
                    // 'value'     => function($model){
                    //     return $model->payment;
                   // },
                ],
                [
                    'attribute' => 'payment_id',
                    'options'   => ['width' => '10%'],
                    'value' => function($model){
                        return isset($model->payment_id) ? $model->payment_id : '';
                    }
                ],
                [
                    'attribute' => 'order_sn',
                    'options'   => ['width' => '10%'],
                    'value' => function($model){
                        return isset($model->order_sn) ? $model->order_sn : '';
                    }
                ],
                // [
                //     'attribute' =>'grade_id',
                //     'value'     => function($model){
                //         return isset($model->grade->grade_name) ? $model->grade->grade_name : '未知';
                //     }
                // ],
                [
                    'attribute' =>'user_id',
                    'value'     => function($model){
                        return '[UID-'.$model->user_id.']'.Yii::$app->user->identity->getUserName($model->user_id);
                    }
                ],
                // [
                //     'attribute' =>'introducer_id',
                //     'value'     => function($model){
                //         return isset($model->introducer->username) ? $model->introducer->username : '未知';
                //     }
                // ],
               
                // 'total_course',
    			// 'presented_course',
                'total_price',
                'coupon_price',
                'real_price',
                 [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'enum'      => CourseOrderItem::optPayment(),
                    'attribute' =>'payment',
                    'format'    => 'raw',
                    'value'     => function($model){
                        return $model->payment;
                    },
                ],
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'enum'      => CourseOrderItem::optPaymentStatus(),
                    'attribute' =>'payment_status',
                    'format'    => 'raw',
                    'value'     => function($model){
                        return $model->payment_status;
                    },
                ],
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'enum'      => CourseOrderItem::optStatus(),
                    'attribute' =>'status',
                    'format'    => 'raw',
                    'value'     => function($model){
                        return $model->status;
                    },
                ],
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


