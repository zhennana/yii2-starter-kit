<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;
use backend\modules\campus\models\StudentRecordKey;
use backend\modules\campus\models\StudentRecordValueToFile;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
* @var yii\widgets\ActiveForm $form
*/
//var_dump(413213);exit;

Modal::begin([
    'options' => [
        'id' => 'update-modal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'id' => 'update-modal',
    'header' => '<h4 class="modal-title">创建标题</h4>',
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">关闭</a>',
]);

Modal::end();
?>

<div class="student-record-value-form">

    <?php $form = ActiveForm::begin([
    'id' => 'StudentRecordValue',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>
          <?php   if(isset($info) && $info != NULL){
            //var_dump(count($info));exit;
                    echo $form->errorSummary($info);
            } ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
        <?php
            if(isset($model) && is_array($model) && !empty($model)){
                foreach ($model as $key => $value) {
                    if($value['key']['student_record_key_id'] == 4){
                        $image = $value;
                        continue;
                    }
        ?>

        <?= $form->field($value['value'], "[{$value['key']['student_record_key_id']}]student_record_key_id",[
            'options'=>['tag'=>null]])
            ->hiddenInput(['maxlength' => true,'value'=>$value['key']['student_record_key_id']])
            //->hiddenInput()
            ->label(false)
            ->hint(false)
        ?>

        <?= $form->field($value['value'], "[{$value['key']['student_record_key_id']}]student_record_id")
            ->hiddenInput(['maxlength' => true,'value'=>$_GET['student_record_id']])
           // ->hiddenInput()
            ->label(false)
            ->hint(false)
        ?>

        <?= $form->field($value['value'], "[{$value['key']['student_record_key_id']}]body")
            ->textArea(['maxlength' => true])
            ->label($value['key']['title'])
            ->hint(false) 
        ?>
        <?php /* echo  common\widgets\Qiniu\UploadStudentRecordValue::widget([
                    'uptoken_url' => yii\helpers\Url::to(['courseware-category/token-cloud']),
                    'keys'        => $value['key']['student_record_key_id'],
                   // 'upload_url'  => yii\helpers\Url::to(['upload-cloud','courseware_id'=>$model->courseware_id
                   ]);*/
        ?>
        <?php
                }
            if(isset($image)){
                echo  $form->field($image['value'], "[{$image['key']['student_record_key_id']}]body")
                        ->hiddenInput(['maxlength' => true,'value'=>'我的图片'])
                        ->label($image['key']['title'])->hint(false)->label(false);
                echo  $form->field($image['value'], "[{$image['key']['student_record_key_id']}]student_record_key_id",[
                                'options'=>['tag'=>null]])
                            ->hiddenInput(['maxlength' => true,'value'=>$image['key']['student_record_key_id']])
                            //->hiddenInput()
                            ->label(false)
                            ->hint(false);
                echo   $form->field($image['value'], "[{$image['key']['student_record_key_id']}]student_record_id")
                             ->hiddenInput(['maxlength' => true,'value'=>$_GET['student_record_id']])
                            // ->hiddenInput()
                            ->label(false)
                            ->hint(false);
                echo  common\widgets\Qiniu\UploadStudentRecordValue::widget([
                    'uptoken_url' => yii\helpers\Url::to(['courseware-category/token-cloud']),
                    'keys'        => $image['key']['student_record_key_id'],
                   // 'upload_url'  => yii\helpers\Url::to(['upload-cloud','courseware_id'=>$model->courseware_id
                   ]);
            }
    }
        ?>

<!-- attribute student_record_id -->
            <!-- <? //= $form->field($model, 'student_record_id')->textInput()->label($value['key']) ?>
 -->
<!-- attribute body -->


<!-- attribute status -->
            <!-- <?// = $form->field($model, 'status')->textInput() ?> -->

<!-- attribute sort -->
        <!--    <? //= $form->field($model, 'sort')->textInput() ?> -->
        </p>
        <?php $this->endBlock(); ?>
        <?php $this->beginBlock('keys');
            $model = new StudentRecordKey;
         ?>
            <p>
<!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->textInput() ?>

<!-- attribute grade_id -->
            <?= $form->field($model, 'grade_id')->textInput() ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->textInput() ?>

<!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput() ?>

<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        <?=
        Tabs::widget(
                 [
                'encodeLabels' => false,
                'items' => [
                [
                    'label'   => Yii::t('backend', '创建学生档案'),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
                    ]
                ]
    );
    ?>
        <hr/>
        <?= Html::submitButton(
            Yii::t('backend', 'Create'),
        ['class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<?=  '<div  class="table-responsive">'.\yii\grid\GridView::widget([
                'layout'=>'{summary}{pager}<br/>{items}{pager}',
                'dataProvider'=>  new \yii\data\ActiveDataProvider([
                        'query' => StudentRecordValueToFile::find()->where(['student_record_value_id'=>$image['value']->student_record_value_id]),
                        'pagination' => [
                            'pageSize' => 20,
                            'pageParam'=>'page-studentrecordvaluetofiles',
                        ]
                    ]),
                //'filterModel'=> $CoursewareToCoursewareSearch,
                'columns'=>[
                    [
                    'attribute'=>'student_record_value_to_file_id',
                    'label'    => 'id',
                    ],
                    [
                    //'attribute' => '2',
                    'label'     => '内容',
                    'value'     =>function($model){
                        return $model->studentRecordValue->body;
                        }
                    ],
                    [
                        'label' => '文件',
                        'format' => 'raw',
                        'value' => function($model, $key, $index, $grid){
                            $url = $model->fileStorageItem->url.$model->fileStorageItem->file_name;
                            if(strstr($model->fileStorageItem->type,'image')){
                                return Html::a('<img width="50px" height="50px" class="img-thumbnail" src="'.$url.'?imageView2/1/w/50/h/50" />', $url.'?imageView2/1/w/500/h/500', ['title' => '访问','target' => '_blank']);
                            }else{
                                return Html::a($model->fileStorageItem->type, $url, ['title' => '访问','target' => '_blank']);
                            }
                        }
                    ],
                    [
                        'class'=>'yii\grid\ActionColumn',
                        'header'=>'操作审核',
                        'template'=>'{button}',
                        'buttons'=>[
                            'button'=>function($url,$model,$key){
                                return Html::button('删除',[
                                        'class'=>'btn btn-danger audit',
                                        'title'=>'查看',
                                        'field_id'   => $model->student_record_value_to_file_id
                                        ]);
                            }
                        ]
                    ]
                ]
            ]).'</div>'
        ?>
<?php

$requestUpdateUrl = Url::toRoute(['student-record-key/ajax-student-key']);
//var_dump($requestUpdateUrl);exit;
$updateJs = <<<JS
    $('.data-update').on('click', function () {
        $.get('{$requestUpdateUrl}', { share_stream_id: $(this).closest('tr').data('key') },
            function (data) {
                console.log(data);
                $('.modal-body').html(data);
            }
        );
    });
JS;
$this->registerJs($updateJs);
?>
<script type="text/javascript">
    var dom = '<li class="data-update" >';
    var visible = "<?php  echo Yii::$app->user->can('manager') ?>";
    if(visible){
        dom += '<a href="#w0-tab1" data-toggle="modal" data-target="#update-modal" >创建标题</a>';
        dom += '</li>';
        $('#w0').append(dom);
    }

    $(document).on("click",".audit",function(){
        field_id = $(this).attr("field_id");
        var data = {"field_id":field_id};
        $.ajax({
            url:"<?php echo Url::to(['student-record-value/remove']) ?>",
            type : "GET",
            data :data,
            success:function(result){
                if(result.status){
                    alert(result.status);
                    window.location.reload();
                }
                if(result.error){
                    alert(result.error);
                }

            }
        })
    });
</script>
