<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\modules\campus\models\GradeCategory;

$parent_ids = GradeCategory::find()->where(['parent_id'=>0])->asArray()->all();
$parent_ids = ArrayHelper::map($parent_ids,'grade_category_id','name');
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\GradeCategorySearch $searchModel
*/

$this->title = Yii::t('backend', '班级分类管理');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('P_director', ['route' => true]) || \Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{view}';
    }

    if (\Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{update}';
    }

    if (\Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{delete}';
    }
    if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;
    } else {
        Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('cruds', 'New'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete}";
    }
    $actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud grade-categroy-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '班级分类管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('manager', ['route' => true]) || \Yii::$app->user->can('E_manager')){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
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
                        'items' => [

                        ]
                    ],
                    'options' => [
                    'class' => 'btn-default'
                    ]
                ]
            );?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => Yii::t('backend', '首页'),
                'lastPageLabel' => Yii::t('backend', '尾页'),
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
                                'title' => Yii::t('backend', '查看'),
                                'aria-label' => Yii::t('backend', '查看'),
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
			'grade_category_id',
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'parent_id',
                'enum'      => $parent_ids,

            ],
            [
                'attribute' => 'creater_id',
                'value'     => function($model){
                    return GradeCategory::getUserName($model->creater_id);
                }
            ],
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'enum'      => GradeCategory::optsStatus()

            ],
			'name',
            'updated_at:datetime',
            'created_at:datetime',
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


