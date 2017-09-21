<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;

use common\models\User;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
* @var yii\widgets\ActiveForm $form
*/

?>
<div class="user-to-grade-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'UserToGrade',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <?php echo $form->errorSummary($newModel); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

            <?= $form->field($model,'user_id')->textInput(['disabled'=>'disabled','value'=>Yii::$app->user->identity->getUserName($model->user_id)])->label()->hint(false)?>
            <?= $form->field($model,'school_id')->textInput(['disabled'=>'disabled','value'=>isset($model->school->school_title)? $model->school->school_title : $model->school_id])->label()?>
            <?= $form->field($model,'[0]grade_id',[])->textInput(['disabled'=>'disabled','value'=>isset($model->grade->grade_name)? $model->grade->grade_name : $model->grade_id])->label()?>
        <!-- attribute grade_id -->
            <?= $form->field($newModel, 'grade_id')->widget(Select2::className(),[
                'data' =>  $newModel->getlist(1,$model->school_id),
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])->label('目标班级')->hint('') ?>


        </p>
        <?php $this->endBlock(); ?>

        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '转班'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>
        <hr/>

        

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('common','转班'),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

