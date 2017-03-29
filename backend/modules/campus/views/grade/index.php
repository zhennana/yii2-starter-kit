<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\GradeCategory;

$school_ids = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
$school_ids = ArrayHelper::map($school_ids,'id','school_title');
//var_dump($school_ids);exit;
$group_category_ids = GradeCategory::find()->where(['status'=>GradeCategory::CATEGORY_OPEN])->asArray()->all();
$group_category_ids = ArrayHelper::map($group_category_ids,'grade_category_id','name');
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\GradeSearch $searchModel
*/

$this->title = Yii::t('backend', 'Grades');
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
<div class="giiant-crud grade-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '班级') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('manager', ['route' => true])){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
                ['create'], ['class' => 'btn btn-success']) 
            ?>
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
                'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', '关系'),
                'dropdown' => [
                    'options' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'url' => ['grade-profile/index'],
                            'label' => '<i class="glyphicon glyphicon-arrow-left">&nbsp;' . Yii::t('backend', 'Grade Profile') . '</i>',
                        ],
                        
                    ]
                ],
                'options' => [
                    'class' => 'btn-default'
                ]
            ]);
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
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'school_id',
                    'format'      => 'raw',
                    'enum'      => $school_ids,
                    'value'     => function($model){
                        return Html::a(
                            $model->school->school_title,
                            [ 
                                'school/view','id'=>$model->school_id
                            ]);
                    },
                    
                ],
                [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' =>'group_category_id',
                    'format'    =>'raw',
                    'enum'      => $group_category_ids,
                    'value'     =>function($model){
                        return Html::a(
                            isset($model->gradeCategory->name) ? $model->gradeCategory->name: '',
                            ['/campus/grade-categroy','grade-categroy_id'=>$model->group_category_id]
                            );
                    }
                ],
                    //'group_category_id',
        			'grade_title',
        			'creater_id',
        			//'classroom_group_levels',
        			'owner_id',
        			'sort',
        			//'status',
                [
                    'class'     =>\common\grid\EnumColumn::className(),
                    'attribute' =>'status',
                    'format'        => 'raw',
                    'value'     => function($model){
                        return $model->status;
                    },
                    'enum'      => Grade::optsStatus()
                ],
                'updated_at:datetime',
                'created_at:datetime'
        			/*'graduate',*/
        			/*'time_of_graduation:datetime',*/
        			/*'time_of_enrollment:datetime',*/
        			/*'grade_name',*/
                ],
            ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


