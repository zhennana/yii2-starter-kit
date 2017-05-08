<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$carousel_id = isset($carousel->id) ? $carousel->id : $model->carousel_id ;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="widget-carousel-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model) ?>
   <?php
        if($model->isNewRecord){
             echo  \common\widgets\Qiniu\UploadCarousel::widget([
                'uptoken_url' => yii\helpers\Url::to(['token-cloud']),
                'upload_url'  => yii\helpers\Url::to(['upload-cloud']),
            ]);
         }else{
            echo $model->path ? Html::img($model->getImageUrl(), ['style'=>'width: 100%']) : null;
         }
    ?>
               
    <?php echo $form->field($model,'carousel_id')->hiddenInput(['value'=>$carousel_id])->label('') ?>
    
    <?php echo $form->field($model, 'order')->textInput() ?>

    <?php echo $form->field($model, 'url')->textInput(['maxlength' => 1024])->label(false) ?>
    <?php echo $form->field($model,'base_url')->hiddenInput(['value'=>Yii::$app->params['qiniu']['wakooedu']['domain']])->label('') ?>

    <?php echo $form->field($model, 'caption')->widget(
        \yii\imperavi\Widget::className(),
        [
            'plugins' => ['fullscreen', 'fontcolor', 'video'],
            'options'=>[
                'minHeight'=>400,
                'maxHeight'=>400,
                'buttonSource'=>true,
                'convertDivs'=>false,
                'removeEmptyTags'=>false
            ]
        ]) ?>

    <?php echo $form->field($model, 'status')->checkbox() ?>

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    function delattach(path, type) {
    var send_data = new Object();
    send_data.path = path;
    if (type == 1)
    {
        url = "index.php?r=campus/courseware-category/delete-cloud";
    }
    else
    {
        url = "index.php?r=campus/courseware-category/delete-cloud";
    }    
    jQuery.ajax({
        type: "post",
        url: url,
        data: send_data,
        async: false,
        success: function(response){
            var pathid = path.slice(0,-4);
            if(response.status == 1){
                $('#coursewarecategory-banner_src').val("");
                $('#pickfiles').show();
                $('.progressContainer').remove();
                $('thead').hide();
                $("#widgetcarouselitem-path").remove();
                $("#"+pathid+" .linkWrapper").removeAttr('href');
                $("#"+pathid+" .info").html("<span class='text-red'>已删除</span>");
            }
//          alert(pathid);
            
            return true;
        }
    });
}; 
</script>