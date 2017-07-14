<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use yii\helpers\StringHelper;
use backend\modules\campus\models\WorkRecord;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\WorkRecord $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="work-record-form">

    <?php $form = ActiveForm::begin([
    'id' => 'WorkRecord',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')
            ->textInput(['value'=>Yii::$app->user->identity->getUserName($model->user_id),'disabled'=>"disabled"]) ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true,'disabled'=>"disabled"]) ?>

<!-- attribute status -->
<!-- attribute status -->
            <?= $form->field($model,'status')->widget(Select2::className(),[
                'data'          => WorkRecord::optsStatus(),
                'hideSearch'    => true,
                // 'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ])->label('状态') ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'WorkRecord'),
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

