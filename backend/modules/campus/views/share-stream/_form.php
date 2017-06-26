<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use backend\modules\campus\models\ShareStream;
use backend\modules\campus\models\search\ShareToFileSearch;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
* @var yii\widgets\ActiveForm $form
*/
$school = Yii::$app->user->identity->schoolsInfo;
$school = ArrayHelper::map($school,'school_id','school_title');

 $ShareToFileSearch  = new ShareToFileSearch;
 $ShareToFile =   $ShareToFileSearch->search($_GET);
 $ShareToFile->query->andwhere(['share_stream_id'=>$model->share_stream_id]);
?>


<div class="share-stream-form">

    <?php $form = ActiveForm::begin([
        'id' => 'ShareStream',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]
    );
    ?>

    <?php 
        if(isset($message)){
            //var_dump($message);exit;
             echo $form->errorSummary($message);
        }else{

             echo $form->errorSummary($model);

        }
         ?>
    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
        <?= $form->field($shareToGrade,'school_id')
                    ->widget(Select2::ClassName(),
                        [
                            //'id'=>'div_school_id',
                            'data'=>$school,
                            //
                            'maintainOrder'=>true,
                            'options'=>[
                                'value'=>isset($model->school_id)? $model->school_id : [],
                                'placeholder'=>'请选择','multiple'=>false],
                            'pluginOptions'=>[
                                'allowClear'=> false,
                            ],
                            'toggleAllSettings'=>[
                                    'selectLabel' =>'<i class="glyphicon glyphicon-unchecked"></i> 全选',
                                    'unselectLabel'=>'<i class="glyphicon glyphicon-check"></i>取消全选'
                            ],
                            'pluginEvents'=>[
                                "change" => "function() {
                                    handleChange(1,$(this).val(),'#sharestreamtograde-grade_id',$('#sharestreamtograde-grade_id').val());
                                }",
                            ]
                        ]);
            ?>
            <?php
                if(!$model->isNewRecord){
                    $shareToGradeIds = $model->shareToGrade;
                 // var_dump(ArrayHelper::map($shareToGrade,'grade_id','grade_id'));exit;
                 //$shareToGrade->grade_id =  
                 $shareToGradeIds =ArrayHelper::map($shareToGradeIds,'grade_id','grade_id');
                 //var_dump($shareToGradeIds);exit;
              }

            ?>
            <?= $form->field($shareToGrade,'grade_id')->widget(Select2::className(),
                        [
                            'data'=> $shareToGrade->getList(1,$model->school_id),
                            'size' => Select2::SMALL,
                            'options'=>[
                            'value'=> isset($shareToGradeIds) ? $shareToGradeIds : [] ,
                            'placeholder'=>'请选择','multiple'=>true],
                            'pluginOptions'=>[
                                'allowClear'=> true,
                            ],
                            'toggleAllSettings'=>[
                                    'selectLabel' =>'<i class="glyphicon glyphicon-unchecked"></i> 全选',
                                    'unselectLabel'=>'<i class="glyphicon glyphicon-check"></i>取消全选'
                            ],
                        ]) ?>
<!-- attribute body -->
			<?= $form->field($model, 'body')->textInput(['maxlength' => true]) ?>
<!-- attribute status -->
			<?= $form->field($model, 'status')->widget(
                            Select2::className(),
                            [
                                'data'=>ShareStream::optsStatus(),
                              //  'options'=>['placeholder'=>'请选择'],
                            ]
            ) ?>
             <?php
                echo common\widgets\Qiniu\UploadShareStream::widget([
                        'uptoken_url' => yii\helpers\Url::to(['courseware-category/token-cloud']),
                ]);
            ?>
        </p>
        <?php $this->endBlock(); ?>
        <?=
            Tabs::widget(
                [
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label'   => Yii::t('backend', '分享消息'),
                            'content' => $this->blocks['main'],
                            'active'  => true,
],
                    ]
                ]
    );
    ?>
        <hr/>


        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php
    if(!$model->isNewRecord){
?>

<div style='position: relative'>
<div style='position:absolute; right: 0px; top: 0px;'>
  
</div>
</div>
<?php Pjax::begin(['id'=>'pjax-ShareToFiles', 'enableReplaceState'=> false, 'linkSelector'=>'#pjax-ShareToFiles ul.pagination a, th a', 'clientOptions' => ['pjax:success'=>'function(){alert("yo")}']]) ?>
<?=
 '<div class="table-responsive">'
 . \yii\grid\GridView::widget([
    'layout' => '{summary}{pager}<br/>{items}{pager}',
    'dataProvider' => $ShareToFile,
    'filterModel'  =>$ShareToFileSearch,
    'pager'        => [
        'class'          => yii\widgets\LinkPager::className(),
        'firstPageLabel' => Yii::t('backend', 'First'),
        'lastPageLabel'  => Yii::t('backend', 'Last')
    ],
    'columns' => [
 [
    'class'      => 'yii\grid\ActionColumn',
    'template'   => '{delete}',
    'contentOptions' => ['nowrap'=>'nowrap'],
    'urlCreator' => function ($action, $model, $key, $index) {
        // using the column name as key, not mapping to 'id' like the standard generator
        $params = is_array($key) ? $key : [$model->primaryKey()[0] => (string) $key];
        $params[0] = 'share-to-file' . '/' . $action;
        $params['ShareToFile'] = [
            'share_stream_id' => $model->primaryKey()[0]];
        return $params;
    },
    'buttons'    => [
        
    ],
    'controller' => 'share-to-file'
],
        'share_to_file_id',
// generated by schmunk42\giiant\generators\crud\providers\core\RelationProvider::columnFormat
    [
       // 'class' => yii\grid\DataColumn::className(),
        'attribute' => 'file_storage_item_id',
        'value' => function ($model) {
            if ($rel = $model->getFileStorageItem()->one()) {
                return Html::a($rel->file_storage_item_id, ['file-storage-item/view', 'file_storage_item_id' => $rel->file_storage_item_id,], ['data-pjax' => 0]);
            } else {
                return '';
            }
        },
        'format' => 'raw',
    ],
    [
        'label'=>'图片',
        'format' => 'raw',
        'value'=>function($model){
            if($model->fileStorageItem){
                $url = $model->fileStorageItem->url.$model->fileStorageItem->file_name;
                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
            }
        }
    ],
        'status',
        'updated_at:datetime',
        'created_at:datetime',
        [
                    'class'=>'yii\grid\ActionColumn',
                    'header'=>'操作审核',
                    'template'=>'{button}',
                    'buttons'=>[
                        'button'=>function($url,$model,$key){
                            return Html::button('删除',[
                                    'class'=>'btn btn-danger audit',
                                    'title'=>'查看',
                                    'share_to_file_id'   => $model->share_to_file_id
                                    ]);
                        }
                    ]
        ]
]
])
 . '</div>' 
?>
<?php Pjax::end() ?>
<?php
    }
?>
    <script>
        function handleChange(type_id,id,form,grade_id){
            $.ajax({
                "url":"<?php echo Url::to('ajax-form') ?>",
                'type':"GET",
                "data":{type_id:type_id,id:id},
                'success':function(data){
                    $(form).html(data);
                    $(form).val(grade_id);
                }
            })
        }


   $(document).on("click",".audit",function(){
        share_to_file_id = $(this).attr("share_to_file_id");
        var data = {"share_to_file_id":share_to_file_id};
        $.ajax({
            url:"<?php echo Url::to(['share-to-file/delete']) ?>",
            type : "GET",
            data :data,
            success:function(result){
                if(result.status){
                   alert(result.status);
                    window.location.reload();
                }
                if(result.error){
                    alert(result.error);
                    window.location.reload();
                }

            }
        })
    });

    </script>