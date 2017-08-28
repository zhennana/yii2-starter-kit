    <?php

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\grid\GridView;

    /**
    * @var yii\web\View $this
    * @var yii\data\ActiveDataProvider $dataProvider
        * @var backend\modules\campus\models\search\ContactSearch $searchModel
    */

    $this->title = Yii::t('backend', '联系我们');
    $this->params['breadcrumbs'][] = $this->title;


    /**
    * create action column template depending acces rights
    */
    $actionColumnTemplates = [];

    if (\Yii::$app->user->can('manager', ['route' => true])) {
        $actionColumnTemplates[] = '{view}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true])) {
       // $actionColumnTemplates[] = '{update}';
    }

    if (\Yii::$app->user->can('manager', ['route' => true])) {
       // $actionColumnTemplates[] = '{delete}';
    }
    if (isset($actionColumnTemplates)) {
    $actionColumnTemplate = implode(' ', $actionColumnTemplates);
        $actionColumnTemplateString = $actionColumnTemplate;
    } else {
    Yii::$app->view->params['pageButtons'] = Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']);
        $actionColumnTemplateString = "{view} {update} {delete}";
    }
    $actionColumnTemplateString = '<div class="action-buttons">'.$actionColumnTemplateString.'</div>';
    ?>
    <div class="giiant-crud contact-index">

        <?php
            //echo $this->render('_search', ['model' =>$searchModel]);
        ?>

        
        <?php \yii\widgets\Pjax::begin(['id'=>'pjax-main', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-main ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>

        <h1>
            <?= Yii::t('backend', '联系我们') ?>
            <small>
                列表
            </small>
        </h1>
        <div class="clearfix crud-navigation">
    <?php
    if(\Yii::$app->user->can('manager', ['route' => true])){
    ?>
            <div class="pull-left">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
    <?php
    }
    ?>
            <div class="pull-right">
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
        			'username',
        			'phone_number',
        			'body',
        			//'auditor_id',
                    [
                        'attribute'=>'auditor_id',
                        'value'    => function($model){
                            if(isset($model->user->username) && !empty($model->user->username)){
                                return $model->user->username;
                            }else{
                                return '未知';
                            }
                        }
                    ],
        			//'status',
                    [
                        'class'     =>\common\grid\EnumColumn::className(),
                        'attribute' => 'status',
                        'enum'      => \backend\modules\campus\models\Contact::optsStatus(),
                        'filter'    => \backend\modules\campus\models\Contact::optsStatus(),
                    ],  
        			'email:email',
                    'updated_at:datetime',
                    'created_at:datetime',
               
                [
                    'class'=>'yii\grid\ActionColumn',
                    'header'=>'操作审核',
                    'template'=>'{button}',
                    'buttons'=>[
                        'button'=>function($url,$model,$key){
                            if($model->status == \backend\modules\campus\models\Contact::CONTACT_STATUS_NOT_AUDIT){
                                return Html::button('查看',[
                                    'class'=>'btn btn-danger audit',
                                    'title'=>'查看',
                                    'id'   => $model->contact_id
                                    ]);
                            }else{
                               return  Html::button('已查看', [
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
        contact_id = $(this).attr("id");
        var data = {"contact_id":contact_id};
        $.ajax({
            url:"<?php echo Url::to(['update-audit']) ?>",
            type : "POST",
            data :data,
            success:function(result){
                if(result.status){
                    $("#"+contact_id).text("已查看");
                    $("#"+contact_id).removeClass('btn-danger').attr("disabled",true);
                     alert('状态更改成功');
                     window.location.reload()
                }else{
                    alert('状态更改失败');
                }

            }
        })
    });
</script>