<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use backend\modules\campus\models\GradeCategory;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\GradeCategroy $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="grade-categroy-form">

    <?php $form = ActiveForm::begin([
        'id' => 'GradeCategroy',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
        ]);
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute parent_id -->
			<?= $form->field($model, 'parent_id')->DropdownList(['prompt'=>'请选择']) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
<!-- attribute creater_id -->
			<!-- <? //= $form->field($model, 'creater_id')->textInput() ?> -->

<!-- attribute status -->
			<?= $form->field($model, 'status')->DropdownList(GradeCategory::optsStatus()) ?>

<!-- attribute name -->
			
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget([
            'encodeLabels' => false,
            'items' => [ 
                [
                'label'   => Yii::t('models', 'GradeCategroy'),
                'content' => $this->blocks['main'],
                'active'  => true,
                ],
            ]
    ]);
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

