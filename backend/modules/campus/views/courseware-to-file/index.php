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
 * @var backend\modules\campus\models\search\CoursewareToFileSearch $searchModel
 */
$this->title = Yii::t('backend', '课件附件');
$this->params['breadcrumbs'][] = $this->title;


/**
 * create action column template depending acces rights
 */
$actionColumnTemplates = [];

if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('E_manager')) {
	//$actionColumnTemplates[] = '{view}';
}

if (\Yii::$app->user->can('manager', ['route' => true]) || Yii::$app->user->can('E_manager')) {
	//$actionColumnTemplates[] = '{update}';
}

if (Yii::$app->user->can('E_manager') || \Yii::$app->user->can('manager', ['route' => true])) {
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
<div class="giiant-crud courseware-to-file-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
?>


    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?php echo Yii::t('backend', '课件附件') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if (\Yii::$app->user->can('manager', ['route' => true])) {
?>
        <div class="pull-left">
           <!--  <?php /*echo Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success'])*/ ?> -->
        </div>
<?php
}
?>
        <div class="pull-right">


<!--             <?php /* echo
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
);*/
?> -->
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
                        'controller' => 'courseware-to-file',
                        'template' => $actionColumnTemplateString
                    ],
                    
                    'courseware_id',
                    [
                        'class'     => \common\grid\EnumColumn::ClassName(),
                        'format'    => 'raw',
                        'attribute' => 'status',
                        'enum'      => \backend\modules\campus\models\CoursewareToFile::optsStatus(),
                    ],
                    'sort',
                    'file_storage_item_id',
                    [
                        'attribute' => 'base_url',
                        'label' => '文件',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid){
                            $url = '';
                            $type = '';
                            if($model->fileStorageItem){
                                $url = $model->fileStorageItem->url.$model->fileStorageItem->file_name;
                                $type = $model->fileStorageItem->type;
                            }
                            if($type && strstr($type,'image')){
                                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
                            }else{
                                return Html::a($type, $url, ['title' => '访问','target' => '_blank']);
                            }
                        }
                    ],
                    [
                        'attribute'=>'type',
                        'label' => '类型',
                        'format'    => 'raw',
                        'value'    =>function($model){
                            if(isset($model->fileStorageItem->type)){
                                 return $model->fileStorageItem->type;
                            }
                            return '';
                        }
                    ],
                    [
                        'attribute'=>'page_view',
                        'label' => '预览量',
                        'format'    => 'raw',
                        'value'    =>function($model){
                            if(isset($model->fileStorageItem->page_view)){
                                 return $model->fileStorageItem->page_view;

                            }
                            return '';
                        }
                    ],
                   'updated_at:datetime',
                    'created_at:datetime'
                ]
	]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>
