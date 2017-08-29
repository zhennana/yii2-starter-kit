<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\modules\campus\models\ActivationCode;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\ActivationCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '激活码');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{view}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true]) || \Yii::$app->user->can('E_manager')) {
        $actionColumnTemplates[] = '{update}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true]) || \Yii::$app->user->can('E_manager')) {
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
<div class="activation-code-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p><?php
           if (\Yii::$app->user->can('E_manager') ||
                \Yii::$app->user->can('manager')
                ) {
        ?>
        <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
            ['create'],
            ['class' => 'btn btn-success']
        ) ?>
        <?= Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '批量创建'),
            ['batch-create'],
            ['class' => 'btn btn-success']
        ) ?>
        <?php } ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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

            'activation_code_id',
            'activation_code',
            'course_order_item_id',
            [
                'attribute' => 'school_id',
                'label'     => '学校',
                'value'     => function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
            // 'grade_id',
            [
                'attribute' => 'user_id',
                'label'     => '用户',
                'value' => function($model){
                    if ($model->user_id) {
                        return '[UID-'.$model->user_id.']'.Yii::$app->user->identity->getUserName($model->user_id);
                    }
                    return '未设置';
                }
            ],
            // 'introducer_id',
            // 'payment',
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'format'    => 'raw',
                'enum'      => ActivationCode::optsStatus(),
                'value'     => function($model){
                    return $model->status;
                },
            ],
            // 'total_price',
            // 'real_price',
            // 'coupon_price',
            // 'coupon_type',
            'expired_at:datetime',
            // 'updated_at:datetime',
            // 'created_at:datetime'
        ],
    ]); ?>

</div>
