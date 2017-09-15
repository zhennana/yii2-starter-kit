<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */
/* @var $form yii\bootstrap\ActiveForm */
 // var_Dump('<pre>',$model->body);exit;
?>

<div class="widget-menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model) ?>
    <div class="col-xs-12" >
        <div class="col-xs-12">
            <?php echo $form->field($model, 'title')->textInput(['maxlength' => 512]) ?>
            <?php echo $form->field($model, '[body]sort')->textInput(['value'=>isset($model->body['sort']) ? $model->body['sort']  : '' ]) ?>
        </div>
<!-- 只让他添加8次 -->
        <div id = "input" class="col-xs-12 row">
            <?php
                unset($model->body['sort']);
                $count = count($model->body);
            ?>
            <?php for($i=0;$i < $count ;$i++){?>
                <div  class="col-xs-12 row">

                <?php
                //添加标题
                    foreach ($model->footer_label as $key => $value) {
                ?>
                <div class="col-xs-5">
                    <?php echo $form->field($model,'[body]['.$i.']'.$value)->textInput(['value'=>isset($model->body[$i][$value]) && is_string($model->body[$i][$value]) ?  $model->body[$i][$value] : ''])?>
                </div>
            <?php } ?>
            <div  class="col-xs-2 clear" style="color: red ;cursor: pointer; height: 59px;" >
                <button type="button" style="vertical-align: bottom; margin-top: 26px " class="btn btn-block btn-danger">清除</button>
            </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-xs-2">
            <button id = "dian" type="button" class="btn btn-block btn-success">添加</button>
        </div>
        <div class="col-xs-12">
            <?php echo $form->field($model, 'status')->checkbox() ?>
        </div>
        <div class="form-group col-xs-12 ">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
    var a = <?php echo $count ?>;

    var label = <?php echo json_encode(array_keys($model->footer_label),JSON_UNESCAPED_UNICODE)?>;
    var attributeLabels = <?php
                foreach ($model->footer_label as $key => $value) {
                    $data[$value] =  $model->getAttributeLabel($value);
                }
                echo json_encode(($data),JSON_UNESCAPED_UNICODE);
     ?>;
     console.log(attributeLabels);
//无限添加表单
    $('#dian').click(function(){
        a = a+1;
        if(label){
            var row = $('<div class="col-xs-12 row"></div>');
            $.each(label,function(i,n){
               var s = 'widgetmenu-body-'+a+'-'+n;
               var b = 'WidgetMenu[body][' + a +']['+n+']';
               var l = n;
               if(attributeLabels[n]){
                  l = attributeLabels[n];
               }
              // console.log(l);
               var string = '<div class="col-xs-5"> <div class="form-group field-'+s;
                string += '"><label class= "control-'+n+ '"' + ' for="' +s+ '">'+ l +'</label> ';
                string += '<input type="text" id="'+ s +'" class="form-control" name="'+b+'" value="">';
                string += '<p class="help-block help-block-error"></p></div></div>';
                 console.log(string);
                row.append(string);
            });
            var yichu= '';
             yichu += '<div  class="col-xs-2 clear" style="color: red ;cursor: pointer; height: 59px;" > <button type="button" style="vertical-align: bottom; margin-top: 26px " class="btn btn-block btn-danger">清除</button></div>';
            row.append(yichu);
            $("#input").append(row);
        }
    });

    $('#input').click(function(event){
        if(event.target.className == 'btn btn-block btn-danger'){
             $(event.target).parent().parent().remove();
        }

    });

</script>
<style type="text/css">
</style>