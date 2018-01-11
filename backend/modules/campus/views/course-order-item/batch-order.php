<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
*/

$this->title = Yii::t('cruds', '批量充值');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '课程订单'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="activation-code-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'ActivationCodeForm',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>
    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(Yii::t('cruds', '取消'),
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

    <?php
        if (isset($info) && !empty($info)) {
            echo $form->errorSummary($info);
        }else{
            echo $form->errorSummary($model);
        }
    ?>

    <?= $form->field($model, 'days')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numbers')->textArea(['rows'=>7]) ?>

    </p>

    <?php $this->endBlock(); ?>
    <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '批量创建兑换码'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>

        <hr/>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('backend', '创建'),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

    <?php ActiveForm::end(); ?>

</div>

