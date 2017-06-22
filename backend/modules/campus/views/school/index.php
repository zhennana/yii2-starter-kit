<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\SchoolSearch $searchModel
*/

$this->title = Yii::t('backend', '学校管理');
$this->params['breadcrumbs'][] = $this->title;

/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')
        || \Yii::$app->user->can('P_director'))
    {
         $actionColumnTemplates[] = '{view}';
    }

    if (\Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')
        )
    {
        $actionColumnTemplates[] = '{update}';
    }

   if (\Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager'))  {
        $actionColumnTemplates[] = '{delete}';
    }

    if (isset($actionColumnTemplates)) {
        $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;
    } else {
        Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete}";
    }
?>
    <div class="giiant-crud school-index">

        <?php
        //   echo $this->render('_search', ['model' =>$searchModel]);
        ?>


        <?php \yii\widgets\Pjax::begin([
                'id'=>'pjax-main', 'enableReplaceState'=> false,
                 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' =>
                    [
                        'pjax:success'=>'function(){alert("yo")}'
                    ]
                ]) 
        ?>

        <h1>
            <?= Yii::t('backend', '学校管理') ?>
            <small> 列表 </small>
        </h1>
        <div class="clearfix crud-navigation">
            <?php
            if (\Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')){
            ?>
                    <div class="pull-left">
                        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
            <?php } ?>
            <div class="pull-right">

                <?= 
                \yii\bootstrap\ButtonDropdown::widget(
                [
                    'id' => 'giiant-relations',
                    'encodeLabel' => false,
                    'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', '相关管理'),
                    'dropdown' => [
                        'options' => [
                        'class' => 'dropdown-menu-right'
                        ],
                        'encodeLabels' => false,
                        'items' => []
                    ],
                    'options' => [
                        'class' => 'btn-default'
                    ]
                ]);?>        
            </div>
        </div>

        <hr />

        <div class="table-responsive">
            <?= GridView::widget(
            [
                'layout' => '{summary}{pager}{items}{pager}',
                'dataProvider' => $dataProvider,
                'pager' => [
                    'class' => yii\widgets\LinkPager::className(),
                    'firstPageLabel' => Yii::t('backend', 'First'),
                    'lastPageLabel' => Yii::t('backend', 'Last')        
                ],
                'filterModel' => $searchModel,
                
                'tableOptions' => [
                    'class' => 'table table-striped table-bordered table-hover'
                ],

                'headerRowOptions' => ['class'=>'x'],
                'columns' => [
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => $actionColumnTemplateString,
                        'urlCreator' => function($action, $model, $key, $index) {
                            // using the column name as key, not mapping to 'id' like the standard generator
                            $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                            $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                            return Url::toRoute($params);
                        },
                        'contentOptions' => ['nowrap'=>'nowrap']
                    ],
                    // 'id',
        			'parent_id',
        			'school_id',
                    'school_title',
        			//'province_id',
                    [
                        'attribute'=>'province_id',
                        'value'=>function($model){
                            if($model->province){
                                return $model->province->province_name;
                            }
                            return '未知';
                        }
                    ],
                    [
                        'attribute'=>'city_id',
                        'value'=>function($model){
                            if($model->city){
                                return $model->city->city_name;
                            }
                            return '未知';
                        }
                    ],
                    [
                        'attribute'=>'region_id',
                        'value'=>function($model){
                            if($model->region){
                                return $model->region->region_name;
                            }
                            return '未知';
                        }
                    ],
                    'address',
        			// 'city_id',
        			// 'region_id',
        			// 'created_id',
        			//'status',
        			/*'sort',*/
        			/*'longitude',*/
        			/*'latitude',*/
        			/*'language',*/
        			//'school_slogan',
        			/*'school_short_title',*/
        			/*'school_logo_path',*/
        			/*'school_backgroud_path',*/
                    [
                        'class'     =>\common\grid\EnumColumn::ClassName(),
                        'attribute' => 'status',
                        'enum'      => \backend\modules\campus\models\School::optsStatus(),
                        'filter'    => \backend\modules\campus\models\School::optsStatus(),
                    ],
                    'created_at:datetime',
                    'updated_at:datetime'
                ],
            ]); ?>
        </div>

    </div>


    <?php \yii\widgets\Pjax::end() ?>


