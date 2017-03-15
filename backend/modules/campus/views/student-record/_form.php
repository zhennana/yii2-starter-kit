<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecord $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="student-record-form">

    <?php $form = ActiveForm::begin([
        'id' => 'StudentRecord',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>
    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
<!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(1),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        "change" => "function() { 
                             handleChange(2,this.value,'#studentrecord-grade_id');
                        }",
                    ]
                ]); ?>

            <?= $form->field($model, 'grade_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(2,$model->school_id),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        "change" => "function() { 
                            handleChange(3,this.value,'#studentrecord-course_id');
                         }",
                    ]
                ]); ?>             

             <?= $form->field($model, 'course_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(3,$model->grade_id),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        "change" => "function() { 
                             handleChange(4,this.value,'#studentrecord-user_id');
                        }",
                    ]
                ]); ?> 

            <?= $form->field($model, 'user_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(4,$model->course_id),
                    'options'=>['placeholder'=>'请选择','multiple'=>true],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'toggleAllSettings'=>[
                            'selectLabel' =>'<i class="glyphicon glyphicon-unchecked"></i> 全选',
                            'unselectLabel'=>'<i class="glyphicon glyphicon-check"></i>取消全选'
                    ],
                    'pluginEvents'=>[
                        "change" => "function() { 

                         }",
                    ]
                ]); ?> 
<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute sort -->
			<?= $form->field($model, 'sort')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=Tabs::widget([
                    'encodeLabels' => false,
                    'items' => [ 
                        [
                            'label'   => Yii::t('backend', 'StudentRecord'),
                            'content' => $this->blocks['main'],
                            'active'  => true,
                        ],
                    ]
                ]);
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

<script>
    function handleChange(type_id,id,form){
            
            console.log('type_id:'+type_id);
            console.log('id:'+id);
        $.ajax({
            "url":"index.php?r=campus/student-record/ajax-form&type_id="+type_id+"&id="+id,
            'type':"GET",
            'success':function(data){
                 $(form).html(data);
               //console.log(data);
            }
        }) 
    }
</script>