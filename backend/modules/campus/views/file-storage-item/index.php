<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\FileStorageItem;
/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\FileStorageItemSearch $searchModel
*/

$this->title = Yii::t('backend', 'File Storage Items');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

// if (\Yii::$app->user->can('campus_file-storage-item_view', ['route' => true])) {
//     $actionColumnTemplates[] = '{view}';
// }

// if (\Yii::$app->user->can('campus_file-storage-item_update', ['route' => true])) {
//     $actionColumnTemplates[] = '{update}';
// }

// if (\Yii::$app->user->can('campus_file-storage-item_delete', ['route' => true])) {
//     $actionColumnTemplates[] = '{delete}';
// }
if (isset($actionColumnTemplates)) {
$actionColumnTemplate = implode(' ', $actionColumnTemplates);
    $actionColumnTemplateString = $actionColumnTemplate;
} else {
Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']);
    $actionColumnTemplateString = "{view} {update} {delete}";
}
$actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
?>
<div class="giiant-crud file-storage-item-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', 'File Storage Items') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('campus_file-storage-item_create', ['route' => true])){
?>
        <div class="pull-left">
            <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', 'New'), ['create'], ['class' => 'btn btn-success']) ?>
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
			//'user_id',
            [
                'attribute' =>'user_id',
                'label'    =>'上传者',
                'format'    => 'raw',
                'value'     =>function($model){
                    return isset($model->user->username) ? $model->user->username : '';
                }
            ],
			[
                'attribute' =>'school_id',
                'label'    =>'学校',
                'format'    => 'raw',
                'value'     =>function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
			[
                'attribute' =>'grade_id',
                'label'    =>'班级',
                'format'    => 'raw',
                'value'     =>function($model){
                    return isset($model->grade->grade_name) ? $model->grade->grade_name : '';
                }
            ],
			'file_category_id',
			//'ispublic',
			// [
   //              'attribute' =>'file_category_id',
   //              'label'    =>'文件分类',
   //              'format'    => 'raw',
   //              'value'     =>function($model){
   //                  return isset($model->fileCategory->title) ? $model->fileCategory->title : '';
   //              }
   //          ],
            [
                'attribute' => 'base_url',
                'format' => 'raw',
                'value' => function($model, $key, $index, $grid){
                    $url = $model->url.$model->file_name;
                    if(strstr($model->type,'image')){
                        return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
                    }else{
                        return Html::a($model->type, $url, ['title' => '访问','target' => '_blank']);
                    }
                }
            ],
			/*'sort_rank',*/
			/*'url:url',*/
            'size',
            'page_view',
			'type',
			'component',
			'file_name',
            //'status',
            [
            'class'     => \common\grid\EnumColumn::ClassName(),
            'format'    => 'raw',
            'attribute' => 'status',
            'enum'      => FileStorageItem::optsStatus(),
            ],
			//'upload_ip',
			'original',
        ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>


