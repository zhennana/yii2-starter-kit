<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
//use kartik\widgets\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use backend\modules\campus\models\Courseware; 
use kartik\file\FileInput;
//use common\widgets\FileInput;

//$image = \Yii::$app->params['qiniu']['wakooedu']['domain'].'/'. 'banner5.jpg';
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Courseware $model
* @var yii\widgets\ActiveForm $form
*/
// if(Yii::$app->session['qiniu']){
//     var_dump(Yii::$app->session['qiniu']);exit;
// }
// echo FileInput::widget([
//     'name' => 'input-fr[]',
//     'language' => 'ch',
//    // 'options' => ['multiple' => false],
//     'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => yii\helpers\Url::to(['token-cloud'])]
// ]);
?>

<div class="courseware-form">
     
    <?php $form = ActiveForm::begin([
        'id' => 'Courseware',
        //'action'=>['create-data'],
        'options'=>['enctype'=>'multipart/form-data'], 
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]);
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
         
<!-- attribute parent_id -->
          <!--   <? // = $form->field($model, 'parent_id')->textInput() ?> -->

<!-- attribute category_id -->
			<!-- <? //  = $form->field($model, 'category_id')->textInput() ?> -->

<!-- attribute level -->
		<!-- 	<? //= $form->field($model, 'level')->textInput() ?> -->

<!-- attribute creater_id -->
		<!-- 	<?  //= $form->field($model, 'creater_id')->textInput() ?> -->


<!-- attribute slug -->
           <!--  <? //= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?> -->
<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]); ?>
           <?php
                //上传七牛云
               //  echo common\widgets\Qiniu\UploadCourseware::widget([
               //      'uptoken_url' => yii\helpers\Url::to(['token-cloud']),
               //      'upload_url'  => yii\helpers\Url::to(['upload-cloud']),
               //      //'delete_url'  => yii\helpers\Url::to(['delete-cloud'])
               // ]);
            ?>   

            <?php
               if($model->isNewRecord){

                    echo $form->field($model,'image')->widget(
                            FileInput::classname(),[
                            //'multiple'=>true,
                                'options'=>['multiple'=>true,'accept'=>'*'],
                                 'pluginOptions' => [
                                    //  //input 上传按钮
                                      'showUpload'=>false,
                                    //   'initialPreview'=>[
                                    //     "http://static.v1.wakooedu.com/banner5.jpg",
                                    // ],
                                      //删除图片用的。
                                    // 'initialPreviewConfig' => [ 
                                    //     'wigth'=>'120px',  
                                    //     //'url' => yii\helpers\Url::to(['delete-cloud']),
                                    // ],
                                    //'previewFileType' => 'any',
                                    // 'uploadAsync'=>true,
                                    // 最小上传
                                    'minFileCount'=>1,

                                    // //最大上传
                                    'maxFileCount'=>10,

                                    // 'overwriteInitial'=>true,
                                    // 'showRemove'=>false,
                                    // //input 选择文件按钮
                                    // 'showBrowse'=>true,

                                    //'browseOnZoneClick'=>true,
                                    
                                    //是否展示默认图片
                                    // 'initialPreviewAsData'=>true,

                                    // 'fileActionSettings'=>[
                                    //    //查看图片按钮 默认为true
                                    //     'showZoom'=>true,
                                    //     //单个图片上传按钮 默认为true
                                    //     'showUpload'=>false,

                                    //     //设置具体图片的移除属性为true,默认为true
                                    //     'showRemove'=>true,
                                    // ],
                                    // //异步提交的控制器 目前不会用 返回
                                    // 'uploadUrl' => yii\helpers\Url::to(['token-cloud']),
                                    //     'browseLabel' => '选择图片',
                                    //     'removeLabel' => '删除'
                        ],

                        //         //上传成功要做的事
                        //         'pluginEvents'=>[
                        //             "fileuploaded"=>"function(event ,data,id,index){
                        //                return data;
                        //             }"
                        // ]
                    ]);
            }else{
                echo $form->field($model,'image')->widget(
                          FileInput::classname(),[
                             'options'=>['accept'=>'*'],
                                'disabled' => true,
                                'pluginOptions' => [

                                     'overwriteInitial'=>true,
                                     'showUpload'=>false,
                                     'initialPreview'=>[
                                        "http://static.v1.wakooedu.com/banner5.jpg",
                                     ],
                                     'initialPreviewConfig'=>[
                                        'wigth'=>'120px',
                                     ],
                                     //是否展示默认图片
                                    'initialPreviewAsData'=>true,
                                ]
                            ]
                    );
            }
            ?> 
           
<!-- attribute body -->
         <!--    <? // = $form->field($model, 'body')->textarea(['rows' => 6]) ?> -->
<!-- attribute access_domain -->
			<!-- <? //  = $form->field($model, 'access_domain')->textInput() ?> -->

<!-- attribute access_other -->
		<!-- 	<?  // = $form->field($model, 'access_other')->textInput() ?> -->

<!-- attribute status -->
			<?= $form->field($model, 'status')->DropDownList(Courseware::optsStatus()) ?>

<!-- attribute items -->
		<!-- 	<? // = $form->field($model, 'items')->textInput() ?> -->

        </p>
        <?php $this->endBlock(); ?>
        
        <?=
            Tabs::widget(
                [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
                        'label'   => Yii::t('backend', 'Courseware'),
                        'content' => $this->blocks['main'],
                        'active'  => true,
                        ],
                    ]
                 ]
    );
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

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

<script type="text/javascript">
//     function delattach(path, type) {
//     var send_data = new Object();
//     send_data.path = path;
//     if (type == 1)
//     {
//         url = "index.php?r=campus/courseware/delete-cloud";
//     }
//     else
//     {
//         url = "index.php?r=campus/courseware/delete-cloud";
//     }    
//     jQuery.ajax({
//         type: "post",
//         url: url,
//         data: send_data,
//         async: false,
//         success: function(response){
//             var pathid = path.slice(0,-4);
//             if(response.status == 1){
//                 $("#"+pathid+" .linkWrapper").removeAttr('href');
//                 $("#"+pathid+" .info").html("<span class='text-red'>已删除</span>");

//             }
// //          alert(pathid);
            
//             return true;
//         }
//     });
//};

// $('.glyphicon glyphicon-upload').fileinput({
//     'uploadUrl':"<?php echo yii\helpers\Url::to(['token-cloud'])?>";//服务器上传操作
//     'uploadAsync':true,
//     'overwriteInitial':false,
//     initialPreview：[    
//         'http://lorempixel.com/800/460/people/1',
//         'http://lorempixel.com/800/460/people/2'
//     ]，
//     'initialPreviewAsData':true,//识别是否只发送预览数据，而不是原始标记
//     'initialPreviewFileType':'image',// image是默认值，可以在下面的配置中覆盖
//     'initialPreviewConfig':[
        
//     ]，
//     'uploadExtraData：'{
//         'img_key':'1000',
//         'img_keywords':'快乐，地方',
//     }
// });
</script>
