<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;
use yii\helpers\ArrayHelper;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\UserToGradeSearch $searchModel
*/

$this->title = Yii::t('backend', '班级人员管理');
$this->params['breadcrumbs'][] = $this->title;
 // $school = [];
 // $grade  = [];
 /*
 $schoolOrGrade = Yii::$app->user->identity->schoolOrGrade;
if(is_string($schoolOrGrade) && $schoolOrGrade == 'all'){
    $school =   ArrayHelper::map(School::find()->asArray()->all(),'school_id','school_title');
    //var_dump(UserToGrade::find()->asArray()->all());exit;
    $grade  =  ArrayHelper::map(Grade::find()->asArray()->all(),'grade_id','grade_name');
}elseif(is_array($schoolOrGrade)){
    $school =   ArrayHelper::map(School::find()->where(['school_id'=>$schoolOrGrade])->AsArray()->all(),'school_id','school_title');
    $grade  =  ArrayHelper::map(Grade::find()->where(['grade_id'=>$schoolOrGrade])->AsArray()->all(),'grade_id','grade_name');
}

*/

/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

     if (\Yii::$app->user->can('P_teacher', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{view}';
    }

     if (\Yii::$app->user->can('P_director', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
        $actionColumnTemplates[] = '{update}';
    }

  /*  if (\Yii::$app->user->can('P_director', ['route' => true])) {
        $actionColumnTemplates[] = '{delete}';
    }
    */
    if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;
    } else {
        Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete}";
    }
        $actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud user-to-grade-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '班级人员管理') ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
    <?php
        if (\Yii::$app->user->can('P_director', ['route' => true]) || \Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
    ?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建班级老师'), ['create','grade_user_type'=>UserToGrade::GRADE_USER_TYPE_TEACHER], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建班级学员'), ['create','grade_user_type'=>UserToGrade::GRADE_USER_TYPE_STUDENT], 
                ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('backend', '查看老师'), ['index','UserToGradeSearch[grade_user_type]'=>UserToGrade::GRADE_USER_TYPE_TEACHER], 
                ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('backend', ' 查看学生'), ['index','UserToGradeSearch[grade_user_type]'=>UserToGrade::GRADE_USER_TYPE_STUDENT], 
                ['class' => 'btn btn-success']) ?>
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
                    'items' => [

                    ]
                ],
                'options' => [
                    'class' => 'btn-default'
                ]
            ]);?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
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
                'user_to_grade_id',
    			[
                    'attribute' =>'user_id',
                    'value'     => function($model){
                       return Yii::$app->user->identity->getUserName($model->user_id);
                    }
                ],
    			[
                    'class'=>\common\grid\EnumColumn::className(),
                    'attribute' =>'school_id',
                    'enum'      => $schools,
                    'value'     => function($model){
                        if(isset($model->school->school_title)){
                            return $model->school->school_title;
                        }
                        return '未知';
                    }
                ],

                [
                    'class'=>\common\grid\EnumColumn::className(),
                    'attribute' =>'grade_id',
                    'enum'      => $grades,
                    'value'     => function($model){
                        if(isset($model->grade->grade_name)){
                            return $model->grade->grade_name;
                        }
                        return '未知';
                    }
                ],
                [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'user_title_id_at_grade',
                    'enum'      => UserToGrade::optsUserTitleType(),
                ],
                [
                    'class'     => \common\grid\EnumColumn::className(),
                    'attribute' => 'grade_user_type',
                    'enum'      => UserToGrade::optsUserType(),
                ],
                [
                    'class'=>\common\grid\EnumColumn::className(),
                    'attribute' =>'status',
                    'enum'      => UserToGrade::optsStatus(),
                ],
    			//'status',
    			//'sort',
    			//'grade_user_type',
                'updated_at:datetime',
                'created_at:datetime',
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


