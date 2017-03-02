<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\campus\models\ApplyToPlay;

/**
* @var yii\web\View $this
* @var yii\data\ActiveDataProvider $dataProvider
    * @var backend\modules\campus\models\search\ApplyToPlaySearch $searchModel
*/

$this->title = Yii::t('common', 'Apply To Plays');
$this->params['breadcrumbs'][] = $this->title;


/**
* create action column template depending acces rights
*/
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('manager', ['route' => true])) {
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
    ?>
<div class="giiant-crud apply-to-play-index">

    <?php
//             echo $this->render('_search', ['model' =>$searchModel]);
        ?>

    
    <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

    <h1>
        <?= Yii::t('common', '报名管理') ?>
        <small>
            List
        </small>
    </h1>
    <div class="clearfix crud-navigation">
<?php
if(\Yii::$app->user->can('manager', ['route' => true])){
?>
        <div class="pull-left">
           <!--  <? //= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', 'New'), ['create'], ['class' => 'btn btn-success']) ?> -->
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
                'label' => '<span class="glyphicon glyphicon-paperclip"></span> ' . Yii::t('common', 'Relations'),
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
                'firstPageLabel' => Yii::t('common', 'First'),
                'lastPageLabel' => Yii::t('common', 'Last'),
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
    			'phone_number',
    			'email:email',
    			'province',
                'city',
    			'region',
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
                    'class'=>'yii\grid\ActionColumn',
                    'header'=>'操作审核',
                    'template'=>'{button}',
                    'buttons'=>[
                        'button'=>function($url,$model,$key){
                            if($model->status == ApplyToPlay::APPLY_TO_PLAY_STATUS_AUDIT ){
                                return Html::button('审核',[
                                    'class'=>'but but-danger audit',
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
            ],
        ]); ?>
    </div>

</div>


<?php \yii\widgets\Pjax::end() ?>

<script>
   $(document).on("click",".audit",function(){
        apply_to_play_id = $(this).attr("id");
        var data = {"apply_to_play_id":apply_to_play_id};
        $.ajax({
            url:"index.php?r=campus/apply-to-play/update-audit",
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
