<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use backend\modules\campus\models\CnProvince;
use backend\modules\campus\models\ApplyToPlay;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\ApplyToPlaySearch $searchModel
*/


$province_id = CnProvince::find()->asArray()->all();
$province_id = ArrayHelper::map($province_id, 'province_id', 'province_name');

/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if(\Yii::$app->user->can('manager', ['route' => true]) || \Yii::$app->user->can('E_manager', ['route' => true])){
        $actionColumnTemplates[] = '{view}';
    }

    // if (\Yii::$app->user->can('manager', ['route' => true])) {
    //     $actionColumnTemplates[] = '{update}';
    // }

    // if (\Yii::$app->user->can('manager', ['route' => true])) {
    //     $actionColumnTemplates[] = '{delete}';
    // }
    if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;
    } else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', 'New'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete}";
    }
    $actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
if(env('THEME') == 'gedu'){
    $this->title = Yii::t('backend', '在线报名');
    $columns = [
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
        'username',
        'guardian',
        'phone_number',
        'age',
        'email',
        'nation',
        'body',
        [
        'class'     =>\common\grid\EnumColumn::className(),
        'attribute' => 'status',
        'enum'      => \backend\modules\campus\models\ApplyToPlay::optsStatus(),
        'filter'    => \backend\modules\campus\models\ApplyToPlay::optsStatus(),
        ], 
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class'    =>'yii\grid\ActionColumn',
            'header'   =>'操作审核',
            'template' =>'{button}',
            'buttons'  =>[
                'button' => function($url,$model,$key){
                    if($model->status == ApplyToPlay::APPLY_TO_PLAY_STATUS_AUDIT ){
                        return Html::button('审核',[
                            'class'=>'btn btn-danger audit',
                            'title'=>'报名审核',
                            'id'   => $model->apply_to_play_id
                            ]);
                    }else{
                       return  Html::button('已审核', [
                            'class' => 'btn btn-default disabled',
                        ]); 
                    }
                }
            ]
        ]
    ];
}else{
 $columns =   [
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
        'username',
        'age',
        'phone_number',
        [
            'class'     => \common\grid\EnumColumn::className(),
            'attribute' => 'province_id',
            'enum'      => $province_id,
            'format'    => 'raw',
        ],
        //'auditor_id',
        //'status',
        [
        'class'     =>\common\grid\EnumColumn::className(),
        'attribute' => 'status',
        'enum'      => \backend\modules\campus\models\ApplyToPlay::optsStatus(),
        'filter'    => \backend\modules\campus\models\ApplyToPlay::optsStatus(),
        ],  
        'created_at:datetime',
        'updated_at:datetime',
        [
            'class'    =>'yii\grid\ActionColumn',
            'header'   =>'操作审核',
            'template' =>'{button}',
            'buttons'  =>[
                'button' => function($url,$model,$key){
                    if($model->status == ApplyToPlay::APPLY_TO_PLAY_STATUS_AUDIT ){
                        return Html::button('审核',[
                            'class'=>'btn btn-danger audit',
                            'title'=>'报名审核',
                            'id'   => $model->apply_to_play_id
                            ]);
                    }else{
                       return  Html::button('已审核', [
                            'class' => 'btn btn-default disabled',
                        ]); 
                    }
                }
            ]
        ]
    ];
}
// $this->title = Yii::t('common', '预约信息');
$this->params['breadcrumbs'][] = $this->title;
    ?>
<div class="giiant-crud apply-to-play-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= $this->title ?>
        <small>
            列表
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('manager', ['route' => true]) || \Yii::$app->user->can('E_manager', ['route' => true])){
?>
        <div class="pull-left">
           <!--  <? //= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', 'New'), ['create'], ['class' => 'btn btn-success']) ?> -->
        </div>
<?php
}
?>
        </div>
    </div>

    <hr />

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => Yii::t('common', '首页'),
                'lastPageLabel' => Yii::t('common', '尾页'),
            ],
            'filterModel' => $searchModel,
            'tableOptions' => [
                'class' => 'table table-striped table-bordered table-hover'
                ],
            'headerRowOptions' => ['class'=>'x'],
            'columns' => $columns,
                
        ]); ?>
    </div>

</div>

<?php \yii\widgets\Pjax::end() ?>

<script>
   $(document).on("click",".audit",function(){
        apply_to_play_id = $(this).attr("id");
        var data = {"apply_to_play_id":apply_to_play_id};
        $.ajax({
            url:"<?php echo Url::to(['apply-to-play/update-audit']) ?>",
            type : "POST",
            data :data,
            success:function(result){
                if(result.status){
                   
                    $("#"+apply_to_play_id).text("已审核");
                    $("#"+apply_to_play_id).removeClass('but-danger').attr("disabled",true);
                     alert('审核成功');
                     window.location.reload()
                }else{
                    alert('审核失败');
                }

            }
        })

   });
</script>
