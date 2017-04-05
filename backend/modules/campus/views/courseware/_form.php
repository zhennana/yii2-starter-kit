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

$categories= \backend\modules\campus\models\CoursewareCategory::find()->where(['parent_id'=>0])->all();
    $categories = \yii\helpers\ArrayHelper::map(
        $categories, 'category_id', 'name'
    );
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
<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute body -->
            <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

<!-- attribute category_id -->
			<?= $form->field($model, 'category_id')->dropDownList($categories,[
           // 'options'=>[$categories=>['disabled'=>'0']],
            'prompt'=>'0']) ?>

<!-- attribute level -->
			<?php // echo $form->field($model, 'level')->textInput(); ?>

<!-- attribute creater_id -->
			<?= $form->field($model, 'creater_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>

<!-- attribute parent_id -->
			<?php // echo $form->field($model, 'parent_id')->textInput() ?>

            <?= $form->field($model, 'tags')->textInput() ?>

<!-- attribute access_domain -->
			<?php //$form->field($model, 'access_domain')->textInput(); ?>

<!-- attribute access_other -->
			<?php //$form->field($model, 'access_other')->textInput(); ?>

<!-- attribute status -->
<?= $form->field($model, 'status')->dropDownList(\backend\modules\campus\models\Courseware::optsStatus(),['prompt'=>'请选择']); ?>
<!-- attribute items -->
			<?php //echo $form->field($model, 'items')->textInput(); ?>

<!-- attribute slug -->
			<?php //echo $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>


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

