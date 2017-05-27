<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use backend\modules\campus\models\ShareStream;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="share-stream-form">

    <?php $form = ActiveForm::begin([
        // 'id' => 'share-stream-to-grade',
        'layout' => 'horizontal',
        'action' => Url::toRoute(['authorization']),
        // 'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]
    );
    ?>


    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            <?= $form->field($model,'share_stream_id')->textInput()->hiddenInput(['value'=>$_GET['share_stream_id']])->label(false)?>
            <?= $form->field($model,'school_id')
                    ->widget(Select2::ClassName(),
                        [
                            //'id'=>'div_school_id',
                            'data'=>$model->getList(),
                            'maintainOrder'=>true,
                            'options'=>[
                            'value'=>isset($default_data['school']) ? array_keys($default_data['school']) : [],'placeholder'=>'请选择','multiple'=>true],
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
            <?= $form->field($model,'grade_id')->widget(Select2::className(),
                        [
                            'data'=> $model->getList(1,isset($default_data['school']) ? array_keys($default_data['school']) :[]),
                            'size' => Select2::SMALL,
                            'options'=>[
                            'value'=> isset($default_data['grade']) ? array_keys($default_data['grade']) : [],
                            'placeholder'=>'请选择','multiple'=>true],
                            'pluginOptions'=>[
                                'allowClear'=> true,
                            ],
                            'toggleAllSettings'=>[
                                    'selectLabel' =>'<i class="glyphicon glyphicon-unchecked"></i> 全选',
                                    'unselectLabel'=>'<i class="glyphicon glyphicon-check"></i>取消全选'
                            ],
                        ]) ?>


        </p>
        <?php $this->endBlock(); ?>
        <?=
            Tabs::widget(
                [
                    'encodeLabels' => false,
                    'items' => [
                        [
                            'label'   => Yii::t('backend', '授权学校班级'),
                            'content' => $this->blocks['main'],
                            'active'  => true,
],
                    ]
                ]
    );
    ?>
        <hr/>

        <?php 
        echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
        [
        // 'id' => 'save-' . $model->formName(),
        'class' => 'create_auth btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

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

    function refresh(){
        parent.location.reload();
    }

    $('.create_auth').on('click',function () {
        $.ajax({
            url: "<?php echo Url::toRoute('authorization') ?>",
            type: "POST",
            dataType: "json",
            data: $('form').serialize(),
            success: function(Data) {
                if(Data = 200){
                    alert('保存成功');
                    refresh();
                }else{
                    alert('保存失败');
                }
            },
            error: function() {
                alert('网络错误!');
            }
        });
        return false;
    });
</script>