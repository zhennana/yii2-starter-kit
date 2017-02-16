<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Courseware $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="courseware-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Courseware',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute category_id -->
			<?= $form->field($model, 'category_id')->textInput() ?>

<!-- attribute level -->
			<?= $form->field($model, 'level')->textInput() ?>

<!-- attribute creater_id -->
			<?= $form->field($model, 'creater_id')->textInput() ?>

<!-- attribute parent_id -->
			<?= $form->field($model, 'parent_id')->textInput() ?>

<!-- attribute access_domain -->
			<?= $form->field($model, 'access_domain')->textInput() ?>

<!-- attribute access_other -->
			<?= $form->field($model, 'access_other')->textInput() ?>

<!-- attribute status -->
			<?= $form->field($model, 'status')->textInput() ?>

<!-- attribute items -->
			<?= $form->field($model, 'items')->textInput() ?>

<!-- attribute slug -->
			<?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute body -->
			<?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'Courseware'),
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

