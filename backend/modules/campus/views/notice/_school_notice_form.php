<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;

use backend\modules\campus\models\Notice;
use backend\modules\campus\models\UserToGrade;
use common\models\User;

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
            if(!isset($info)){
                echo $form->errorSummary($model);
            }else{
                echo $form->errorSummary($info);
            }
        ?>
        <p>
<!-- attribute category -->
            <?= $form->field($model, 'category')->textInput()->hiddenInput([
                'value' => Notice::CATEGORY_ONE
                ])->label(false)->hint(false) ?>

<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute message -->
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

            <?=
                $form->field($model, 'school_id')->widget(Select2::className(),[
                // 'language'          => 'en',
                // 'showToggleAll'     => true,
                'data'              => $schools,
                'theme'             => Select2::THEME_BOOTSTRAP,
                "maintainOrder"     => true,
                'toggleAllSettings' => [
                    'selectLabel'   => '<i class="glyphicon glyphicon-unchecked"></i> 全选',
                    'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>取消全选'
                ],
                'options' => [
                    'placeholder' => '请选择',
                    'multiple'    => true,
                ],
                'pluginOptions' => [
                    'allowClear' => true 
                ]
            ]);
            ?>
<!-- attribute status_send -->
            <!-- <? // $form->field($model, 'status_send')->dropDownList($model->optsStatusSend()) ?> -->

            <?= $form->field($model, 'is_a_push')->checkbox()->label('是否推送') ?>
        </p>
        <?php $this->endBlock(); ?>
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '消息管理'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ]]
        ]); ?>

        <hr/>
        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

