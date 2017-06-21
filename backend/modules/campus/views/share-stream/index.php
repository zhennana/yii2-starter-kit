<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\select2\Select2;
use backend\modules\campus\models\ShareStream;
$schoolIds = \Yii::$app->user->identity->schoolsInfo;
$schoolIds = ArrayHelper::map($schoolIds,'school_id','school_title');

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\ShareStreamSearch $searchModel
*/

$this->title = Yii::t('backend', '分享流列表');
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'options' => [
        'id' => 'update-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'id' => 'update-modal',
    'header' => '<h4 class="modal-title">更改状态</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);

Modal::end();
/**
* create action column template depending acces rights
*/
$actionColumnTemplates = [];

if (\Yii::$app->user->can('user', ['route' => true])) {
    $actionColumnTemplates[] = '{view}';
}


if (\Yii::$app->user->can('user', ['route' => true])) {
    $actionColumnTemplates[] = '{update}';
}
/*
if (\Yii::$app->user->can('user', ['route' => true])) {
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
<div class="giiant-crud share-stream-index">

    <?php
//        echo $this->render('_search', ['model' =>$searchModel]);
    ?>
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('backend', '分享流列表') ?>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('user', ['route' => true])){
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
            'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('backend', 'Relations'),
            'dropdown' => [
            'options' => [
            'class' => 'dropdown-menu-right'
            ],
            'encodeLabels' => false,
            'items' => [
            [
                'url' => ['share-to-file/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('backend', 'Share To File'),
            ],
                                [
                'url' => ['share-stream-to-grade/index'],
                'label' => '<i class="glyphicon glyphicon-arrow-right"></i> ' . Yii::t('backend', 'Share Stream To Grade'),
            ],
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
                },
            ],
            'urlCreator' => function($action, $model, $key, $index) {
                // using the column name as key, not mapping to 'id' like the standard generator
                $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
                $params[0] = \Yii::$app->controller->id ? \Yii::$app->controller->id . '/' . $action : $action;
                return Url::toRoute($params);
            },
            'contentOptions' => ['nowrap'=>'nowrap']
        ],
            'share_stream_id',
			'body',
			//'status',
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'school_id',
                'format'    => 'raw',
                'enum'      => $schoolIds,
                // 'value'     => function($model){
                //     return $model->status;
                //     },
            ],
            [
                'class'     => \common\grid\EnumColumn::className(),
                'attribute' => 'status',
                'format'    => 'raw',
                'enum'      => ShareStream::optsStatus(),
                // 'value'     => function($model){
                //     return $model->status;
                //     },
                ],
			//'author_id',
            [
                'attribute'=>'author_id',
                'label'    => '创建者',
                'value'=>function($model){
                        return $model->getUserName($model->author_id);
                }
            ],
         /*
           [
                'label'=>'授权',
                'format'    => 'raw',
                'value'=>function($modle){
                    return Html::a('授权','#',[
                        'data-toggle' => 'modal',
                        'data-target' => '#update-modal',
                        'class'       => 'data-update',
                    ]);
                }
            ]
        */
        ],
        ]); ?>
    </div>

</div>



<?php \yii\widgets\Pjax::end() ?>

<?php
$requestUpdateUrl = Url::toRoute('authorization');
$updateJs = <<<JS
    $('.data-update').on('click', function () {
        $.get('{$requestUpdateUrl}', { share_stream_id: $(this).closest('tr').data('key') },
            function (data) {
                $('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($updateJs);

?>
