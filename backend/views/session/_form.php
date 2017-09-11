<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use trntv\yii\datetime\DateTimeWidget;

/**
* @var yii\web\View $this
* @var common\models\Session $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="session-form">

    <?php $form = ActiveForm::begin([
    'id' => 'Session',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            

<!-- attribute id -->
			<?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

<!-- attribute expire -->
			<?php echo $form->field($model, 'expire')
                ->widget(
                    DateTimeWidget::className(),
                    [
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'yyyy-MM-dd HH:mm',
                        'momentDatetimeFormat' => 'YYYY-MM-DD HH:mm',
                    ])
            ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->textInput() ?>

<!-- attribute data -->
			<?= $form->field($model, 'data')->textInput() ?>

<!-- attribute udid -->
			<?= $form->field($model, 'udid')->textInput(['maxlength' => true]) ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', 'Session'),
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

