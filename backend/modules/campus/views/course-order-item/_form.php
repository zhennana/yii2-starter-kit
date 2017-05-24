<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="course-order-item-form">

    <?php $form = ActiveForm::begin([
    'id' => 'CourseOrderItem',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute parent_id -->
			<?= $form->field($model, 'parent_id')->textInput() ?>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->textInput() ?>

<!-- attribute grade_id -->
			<?= $form->field($model, 'grade_id')->textInput() ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute introducer_id -->
			<?= $form->field($model, 'introducer_id')->textInput() ?>

<!-- attribute payment -->
			<?= $form->field($model, 'payment')->textInput() ?>

<!-- attribute presented_course -->
			<?= $form->field($model, 'presented_course')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute payment_status -->
			<?= $form->field($model, 'payment_status')->textInput() ?>

<!-- attribute total_course -->
			<?= $form->field($model, 'total_course')->textInput() ?>

<!-- attribute total_price -->
			<?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

<!-- attribute real_price -->
			<?= $form->field($model, 'real_price')->textInput(['maxlength' => true]) ?>

<!-- attribute coupon_price -->
			<?= $form->field($model, 'coupon_price')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('models', 'CourseOrderItem'),
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
        ($model->isNewRecord ? Yii::t('cruds', 'Create') : Yii::t('cruds', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

