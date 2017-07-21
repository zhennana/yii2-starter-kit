<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use \backend\modules\campus\models\Courseware;
use \backend\modules\campus\models\CoursewareCategory;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Courseware $model
* @var yii\widgets\ActiveForm $form
*/

$categories= CoursewareCategory::find()->all();
    $categories = \yii\helpers\ArrayHelper::map(
        $categories, 'category_id', 'name'
    );
if ($model->isNewRecord) {
    $parent = Courseware::find()
        ->where(['parent_id' => 0])
        ->all();
}else{
    $parent = Courseware::find()
        ->where(['parent_id' => 0])
        ->andWhere(['<>','courseware_id',$model->courseware_id])
        ->all();
}
$parent = \yii\helpers\ArrayHelper::map($parent, 'courseware_id', 'title');
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
<!-- attribute parent_id -->
			<?= $form->field($model, 'parent_id')->widget(Select2::className(),[
                'data'    => $parent,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ]); ?>

<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute body -->
            <?php
                foreach ($model->data as $key => $value) {
                  echo   $form->field($model, $value)->textarea(['rows' => 6]);
                }
            ?>
<!-- attribute category_id -->
            <?= $form->field($model, 'category_id')->widget(Select2::className(),[
                'data'    => $categories,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ]); ?>

<!-- attribute level -->
            <?php // echo $form->field($model, 'level')->textInput(); ?>

<!-- attribute creater_id -->
            <?= $form->field($model, 'creater_id')->hiddenInput(['value'=>Yii::$app->user->identity->id])->label(false) ?>


            <?= $form->field($model, 'tags')->textInput() ?>
            

<!-- attribute access_domain -->
			<?php //$form->field($model, 'access_domain')->textInput(); ?>

<!-- attribute access_other -->
			<?php //$form->field($model, 'access_other')->textInput(); ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->widget(Select2::className(),[
                'data'          => Courseware::optsStatus(),
                'hideSearch'    => true,
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
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
    'label'   => Yii::t('backend', '课程'),
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

