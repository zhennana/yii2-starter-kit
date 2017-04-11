<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\CnProvince;
use common\models\school\School;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ApplyToPlay $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="apply-to-play-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'ApplyToPlay',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute username -->
			<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

<!-- attribute age -->
			<?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>

<!-- attribute phone_number -->
            <?= $form->field($model, 'phone_number')->textInput() ?>

<!-- attribute province_id -->
			<?php
                echo $form->field($model,'province_id')->dropDownList(
                    ArrayHelper::map(
                        CnProvince::find()->asArray()->all(),
                        'province_id',
                        'province_name'
                    ),[
                    'prompt'   => '选择地区',
                    'onchange' => '$.get("'.Url::toRoute(['school-lists']).'",{ province_id : $(this).val() }).done(function(data){
                            var str ="";
                            $.each(data,function(k,v){
                                str += "<option value="+k+">"+v+"</option>";
                            });
                            $("select#applytoplay-school_id").html(str);
                        })'
                    ]
                )
            ?>

<!-- attribute school_id -->
			<?php
                echo $form->field($model, 'school_id')->dropDownList(
                    ArrayHelper::map(
                        School::find()
                            ->where(['parent_id' => 0])
                            ->andWhere(['status' => School::SCHOOL_NORMAL])
                            ->asArray()->all(),
                        'id',
                        'school_title'
                    ), ['prompt' => '选择校区'])
            ?>

<!-- attribute auditor_id -->
			<?= $form->field($model, 'auditor_id')->textInput() ?>

<!-- attribute verifyCode -->

<!-- attribute status -->
            <?= $form->field($model, 'status')->dropDownList(\backend\modules\campus\models\ApplyToPlay::optsStatus()); ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '预约信息'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

