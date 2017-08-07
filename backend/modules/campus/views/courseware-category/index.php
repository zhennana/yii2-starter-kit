<?php
/**
 * /Users/bruceniu/Documents/GitHub/yii2-starter-kit/backend/runtime/giiant/a0a12d1bd32eaeeb8b2cff56d511aa22
 *
 * @package default
 */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\campus\models\search\CoursewareCategorySearch $searchModel
 */
$this->title = Yii::t('backend', '课件分类');
$this->params['breadcrumbs'][] = $this->title;


/**
 * create action column template depending acces rights
 */
$actionColumnTemplates = [];

if (\Yii::$app->user->can('P_teacher', ['route' => true]) || Yii::$app->user->can('E_manager') || Yii::$app->user->can('manager')) {
	$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('E_manager')) {
	$actionColumnTemplates[] = '{update}';
}

//if (\Yii::$app->user->can('campus_courseware-category_delete', ['route' => true])) {
	//$actionColumnTemplates[] = '{delete}';
//}
if (isset($actionColumnTemplates)) {
	$actionColumnTemplate = implode(' ', $actionColumnTemplates);
	$actionColumnTemplateString = $actionColumnTemplate;
} else {
	Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
	$actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';

?>
<div class="giiant-crud courseware-category-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
?>


    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?php echo Yii::t('backend', '课件分类') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('E_manager')) {
?>
        <div class="pull-left">
            <?php echo Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
<?php
}
?>
        <div class="pull-right">


            <?php echo
\yii\bootstrap\ButtonDropdown::widget(
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
        <?php echo GridView::widget([
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
            [
            'attribute'=>'name',
            'format'   =>'raw',
            'value'    =>function($model){
                if($model->parent_id != 0){
                     return Html::a($model->name,['courseware/index','CoursewareSearch[category_id]'=>$model->category_id]);
                }else{
                    return $model->name;
                }
            }
            ],
			'description',
			[
			'attribute'=>'banner_src',
			'format'    => 'raw',
			'label'	=>'图片',
			'value'=>function($model){
                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$model->banner_src.'?imageView2/1/w/50/h/50" />', $model->banner_src.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
					
				}
			],
			
			[
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'format'        => 'raw',    
                'enum'      => \backend\modules\campus\models\CoursewareCategory::optsStatus()
            ],

			
		],
	]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>
