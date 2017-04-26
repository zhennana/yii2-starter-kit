<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\Courseware;
//use kartik\grid\GridView;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\CoursewareSearch $searchModel
*/
$categories = \backend\modules\campus\models\CoursewareCategory::find()->where(['status'=>10])->all();
$categories = \yii\helpers\ArrayHelper::map(
        $categories, 'category_id', 'name'
    );
$this->title = Yii::t('backend', '课件管理');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('manager', ['route' => true])) {
        $actionColumnTemplates[] = '{view}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true])) {
        $actionColumnTemplates[] = '{update}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true])) {
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
<div class="giiant-crud courseware-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '课件管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
    <?php
        if(\Yii::$app->user->can('manager', ['route' => true])){
    ?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
    <?php
    }
    ?>
        <div class="pull-right">

                        
            <?= \yii\bootstrap\ButtonDropdown::widget(
                    [
                        'id' => 'giiant-relations',
                        'encodeLabel' => false,
                        'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', 'Relations'),
                        'dropdown' => [
                            'options' => [
                                'class' => 'dropdown-menu-right'
                            ],
                            'encodeLabels' => false,
                            'items' => [

                            ]   
                        ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
            ]
            );
            ?>
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
            'parent_id',
            'title',
            'body',
			//'category_id',
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'category_id',
                'format'        => 'raw',
               
                'enum'      => $categories
            ],
			'level',
			[
                'attribute' =>'creater_id',
                'format'    => 'raw',
                'value'     =>function($model){
                    return isset($model->user->username) ? $model->user->username : '';
                }
            ],
			// 'access_domain',
			// 'access_other',
			'file_counts',
			'page_view',
            'tags',
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'format'        => 'raw',
                'value'     => function($model){
                    return $model->status;
                },
                'enum'      => Courseware::optsStatus()
            ],
            'updated_at:datetime',
            'created_at:datetime',
			/*'body:ntext',*/
            
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


