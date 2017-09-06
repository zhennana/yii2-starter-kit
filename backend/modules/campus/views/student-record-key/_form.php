<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use backend\modules\campus\models\StudentRecordKey;

$requestUpdateUrl = Url::to(['student-record-key/ajax-student-key']);
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordKey $model
* @var yii\widgets\ActiveForm $form
*/
$tab_label ='';
if (env('THEME') == 'gedu') {
    $tab_label = Yii::t('backend', '创建科目标题');
}else{
    $tab_label = Yii::t('backend', '创建档案标题');
}
?>

<script type="text/javascript">
     function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['student-record-key/ajax-form']) ?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
               console.log(data);
                 $(form).html(data);
            }
        })
    }
</script>

<div class="student-record-key-form">

    <?php $form = ActiveForm::begin([
    'id' => 'StudentRecordKey',
    'layout' => 'horizontal',
    // 'action' => [$requestUpdateUrl],
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        "change" => "function() { 
                             handleChange(1,this.value,'#studentrecordkey-grade_id');
                        }",
                    ]
                ])->label('学校'); ?>

            <?= $form->field($model, 'grade_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(1,$model->school_id),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                    ]
                ])->label('班级'); ?> 
<!-- attribute status -->
			<?= $form->field($model, 'status')->widget(
                Select2::className(),
                [
                'data'=>StudentRecordKey::optsStatus(),
                'hideSearch' => true,
                ])->label('状态'); ?>

<!-- attribute sort -->
			<?= $form->field($model, 'sort')->textInput()->label('排序') ?>

        </p>
        <?php $this->endBlock(); ?>

        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
                        'label'   => $tab_label,
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
<?php if (env('THEME') == 'wedu') { ?>

<script>
   

    function refresh(){
        parent.location.reload();
    }
$('form#StudentRecordKey').on('beforeSubmit', function(e) {
   var form = $(this);
   //console.log(form);
        $.ajax({
            url    : '<?php echo  $requestUpdateUrl ?>',
            type   : 'POST',
            data   : form.serialize(),
            success: function (Data)
            {
                 if(Data == 200){
                     //console.log(form);
                    alert('保存成功');
                    refresh();
                }else{
                    //console.log(123);
                    alert('保存失败');
                }
            },
            error  : function ()
            {
               alert('网络错误');
            }
            });
}).on('submit', function(e){
    e.preventDefault();
});
</script>
<?php } ?>
