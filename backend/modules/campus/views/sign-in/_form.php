<?php

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\SignIn;
use common\models\User;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="sign-in-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'SignIn',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

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
                             handleChange(2,this.value,'#signin-grade_id');
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
                            handleChange(3,this.value,'#signin-course_id');
                            handleChange(4,this.value,'#signin-student_id');
                            handleChange(5,this.value,'#signin-teacher_id');
                         }",
                    ]
                ]); ?>

<!-- attribute course_id -->
			<?= $form->field($model, 'course_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(3,$model->grade_id),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        // "change" => "function() {
                        //      handleChange(4,this.value,'#signin-student_id');
                        // }",
                    ]
                ]); ?>
            <?= $form->field($model,'course_schedule_id')->label('排课id') ?>
<!-- attribute student_id -->
			<?= $form->field($model, 'student_id')->widget(Select2::className(),[
                'data' =>[],
                'options'=>['placeholder'=>'请选择'],
            ]) ?>

<!-- attribute teacher_id -->
			<?= $form->field($model, 'teacher_id')->widget(Select2::className(),[
                    'data' =>[],
                    'options'=>['placeholder'=>'请选择'],]
            ) ?>

<!-- attribute auditor_id -->
			<?php
                if ($model->isNewRecord) {
                    // echo $form->field($model, 'auditor_id')->widget(Select2::className(),[
                    //     'data' => ArrayHelper::map(User::find()
                    //         ->where([
                    //             'status' => User::STATUS_ACTIVE
                    //         ])->asArray()->all(),
                    //         'id',
                    //         'username'
                    //     ),
                    //     'options'=>['placeholder'=>'请选择'],
                    // ]);
                }else{
                    // echo $form->field($model, 'auditor_id')->widget(Select2::className(),[
                    //     'data' => ArrayHelper::map(User::find()
                    //         ->where([
                    //             'status' => User::STATUS_ACTIVE
                    //         ])->asArray()->all(),
                    //         'id',
                    //         'username'
                    //     ),
                    //     'options'=>['placeholder'=>'请选择'],
                    //     'disabled' => true,
                    // ]);
                }
            ?>
            <!-- attribute status -->
            <?php
                echo $form->field($model, 'type_status')->widget(Select2::className(),[
                        'data' => SignIn::optsTypeStatus(),
                        'options'=>['placeholder'=>'请选择'],
                ])->label('类型');
            ?>
<!-- attribute status -->
			<?php
                echo $form->field($model, 'status')->widget(Select2::className(),[
                        'data' => SignIn::optsSignInStatus(),
                        'options'=>['placeholder'=>'请选择'],
                ]);
            ?>

        </p>

        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [ 
                [
                    'label'   => ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '更新')),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '更新')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script>
    function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
                console.log(data);
                 $(form).html(data);
            }
        }) 
    }
</script>
