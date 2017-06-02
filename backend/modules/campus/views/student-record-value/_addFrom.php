<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
* @var yii\widgets\ActiveForm $form
*/

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

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
        <?php
            if(isset($model) && is_array($model) && !empty($model)){
                foreach ($model as $key => $value) {
        ?>
        <?= $form->field($value['value'], "[{$key}]student_record_key_id")
            ->textInput(['maxlength' => true,'value'=>$value['key']['student_record_key_id']])->label() ?>
        <?= $form->field($value['value'], "[{$key}]student_record_id")
            ->textInput(['maxlength' => true,'value'=>$_GET['student_record_id']])->label() ?>
        <?= $form->field($value['value'], "[{$key}]body")->textInput(['maxlength' => true])->label($value['key']['title']) ?>
        <?php
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

        <?php   if(isset($info) && $info != NULL){
                    echo $form->errorSummary($info);
            } ?>

        <?= Html::submitButton(
            Yii::t('backend', 'Create'),
        // '<span class="glyphicon glyphicon-check"></span> ' .
        // ($model->isNewRecord ?  : Yii::t('backend', 'Save')),
        [
       // 'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

