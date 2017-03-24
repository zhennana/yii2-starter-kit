<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use backend\modules\campus\models\School;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\School $model
* @var yii\widgets\ActiveForm $form
*/
$school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN,'parent_id'=>'0'])->asArray()->all();
$school = ArrayHelper::map($school, 'id', 'school_title');
?>

<div class="school-form">

    <?php $form = ActiveForm::begin([
        'id' => 'School',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
			<?= $form->field($model, 'parent_id')
            ->dropDownlist(
                $school,
                [ 'prompt'=>'请选择'
            ]) ?>

			<!-- <? // = $form->field($model, 'school_id')
            //->textInput() ?> -->

			<!-- <?php // $form->field($model, 'language')
            //->textInput(['maxlength' => true]) ?>
             -->
			<?= $form->field($model, 'school_title')
            ->textInput(['maxlength' => true]) ?>
			
            <?= $form->field($model, 'school_short_title')
            ->textInput(['maxlength' => true]) ?>
			
            <?= $form->field($model, 'school_slogan')
            ->textInput(['maxlength' => true]) ?>
			
            <?= $form->field($model, 'school_logo_path')
            ->textInput(['maxlength' => true]) ?>
			
            <?= $form->field($model, 'school_backgroud_path')
            ->textInput(['maxlength' => true]) ?>
			
          <!--   <?php // $form->field($model, 'longitude')
            //->textInput() ?> -->

			<!-- <?php // $form->field($model, 'latitude')
            //->textInput() ?> -->

			<?= $form->field($model, 'province_id')
            ->dropDownlist([0=>'--请选择省--']+$model->getCityList(1),
                [
               // 'prompt'=>'--请选择省--',
                'onchange'=>'
                    $.post("'.yii::$app->urlManager->createUrl('campus/school/list').'&typeid=2&id="+$(this).val(),function(data){
                $("select#school-city_id").html(data);
                $("select#school-region_id").html("<option value=0>--请选择区--</option>");
            });',
        ]) ?>

			<?= $form->field($model, 'city_id')
            ->dropDownlist([0=>'--请选择市--']+$model->getCityList(2,$model->province_id),
            [
          //  'prompt'=>'--请选择市--',
            'onchange'=>'
                $.post("'.yii::$app->urlManager->createUrl('campus/school/list').'&typeid=0&id="+$(this).val(),function($data){
                $("select#school-region_id").html($data);
                });',
            ]
            ) ?>
          
			<?= $form->field($model, 'region_id')
            ->dropDownlist($model->getCityList(0,$model->city_id),['prompt'=>'--请选择区--']) ?>

            <?= $form->field($model, 'address')
            ->textInput(['maxlength' => true]) ?>

			<!-- <?  //= $form->field($model, 'created_id')
            //->textInput() ?>
 -->
            <?php
               // if(!$model->isNewRecord){
                echo  $form->field($model, 'status')->dropDownlist(School::optsStatus());
                //}
            ?>
			<?= $form->field($model, 'sort')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
            Tabs::widget(
                 [
                   'encodeLabels' => false,
                     'items' => [ 
                        [
                            'label'   => Yii::t('backend', StringHelper::basename('backend\modules\campus\models\School')),
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