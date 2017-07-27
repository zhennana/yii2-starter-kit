<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use \backend\modules\campus\models\UserToSchool;
/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UserToSchool */
/* @var $form yii\bootstrap\ActiveForm */
$user = [];
if($model->user_id){
    $user[$model->user_id] = Yii::$app->user->identity->getUserName($model->user_id);
}
$school = [];
if($model->school){
    $school[] = $model->school;
    $school  = ArrayHelper::map($school,'school_id','school_title');
}
?>

<div class="user-to-school-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->field($model, 'user_id')->widget(Select2::className(),
        [
            'data'=>$user
        ]);

    ?>

    <?php echo $form->field($model, 'school_id')->widget(Select2::className(),
    [
        'data'=>$school
    ]) ?>
     <!--  <?php /*echo $form->field($model, 'school_user_type')->widget(Select2::className(),
        [
            'data'=>UserToSchool::optsUserType()
        ])*/ ?> -->
     <?php //echo $form->field($model, 'user_title_id_at_school')->textInput() ?>

    <?php echo $form->field($model, 'status')->widget(
        Select2::className(),
        [
            'data'=>UserToSchool::optsUserStatus()
        ])->hint(false);
    ?>

    <?php  //echo $form->field($model, 'sort')->textInput() ?>

  

    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
