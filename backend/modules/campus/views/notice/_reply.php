<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use backend\modules\campus\models\Notice;
use backend\modules\campus\models\UserToGrade;
use common\models\User;
//var_dump($model->getList(1));exit;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Notice $model
* @var yii\widgets\ActiveForm $form
*/
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'Notice',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>
        <?php
                echo $form->errorSummary($answers);
        ?>
        <p>

           <div class="form-group field-notice-message required">
                <label class="control-label col-sm-3" for="notice-message">问题</label>
                <div class="col-sm-6">
                <textarea id="notice-message1" class="form-control" name="" readonly="" rows="6"><?php echo $questions->message ?>
                </textarea>
                </div>
            </div>
           <!-- <div class="col-sm-6">
                <textarea id="notice-message1" class="form-control" name="Notice[][message]" readonly="" rows="6"><?php //echo $questions->message ?></textarea>
                <div class="help-block help-block-error "></div>
                </div> -->
<!-- attribute category -->
            <?= $form->field($answers, 'category')->textInput()->hiddenInput([
                'value' => Notice::CATEGORY_THREE
                ])->label(false)->hint(false) ?>

         

            <?= $form->field($answers, 'replay_notice_id')->textInput()->hiddenInput([
                'value' => $questions->notice_id
                ])->label(false)->hint(false) ?>

            
<!-- attribute message -->
            <?= $form->field($answers, 'message')->textarea(['rows' => 6])->label('回复')->hint(false) ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '回复消息'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ]]
        ]); ?>

        <hr/>
        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($answers->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
            [
                'id'    => 'save-' . $answers->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script type="text/javascript">
    function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
                //$('#course-teacher_id option').remove();
                $(form).html(data);
            }
        })
    }
</script>