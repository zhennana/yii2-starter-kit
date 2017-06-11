<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use backend\modules\campus\models\ShareStream;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
* @var yii\widgets\ActiveForm $form
*/

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

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
           <!--  <? /*$form->field($model1,'school_id[]')
                    ->widget(Select2::ClassName(),
                        [
                            'data'=>$model->type($model1->school_id),
                            'options'=>['placeholder'=>'请选择','multiple'=>true],
                            'pluginOptions'=>[
                                'allowClear'=> true,
                            ],
                            'toggleAllSettings'=>[
                                    'selectLabel' =>'<i class="glyphicon glyphicon-unchecked"></i> 全选',
                                    'unselectLabel'=>'<i class="glyphicon glyphicon-check"></i>取消全选'
                            ]
                        ]);*/ ?> -->
           <!--  <? /*$form->field($model1,'grade_id[]')->widget(Select2::className(),
                        [
                            'data'=>[3,2,3],
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
                                handleChange(3,this.value,'#studentrecord-course_id');
                         }",
                    ]
                        ])*/ ?> -->
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

        <?php 
        echo $form->errorSummary($model1); ?>

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
        
    </script>