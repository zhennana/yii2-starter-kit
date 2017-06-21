<?php

use common\models\User;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\UserProfile;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

use trntv\yii\datetime\DateTimeWidget;

/* @var $this yii\web\View */
/* @var $model backend\models\UserForm */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $roles yii\rbac\Role[] */
/* @var $permissions yii\rbac\Permission[] */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
        <?php echo $form->field($model, 'username') ?>
        <?php echo $form->field($model, 'email') ?>
        <?php echo $form->field($model, 'phone_number') ?>
        <?php echo $form->field($model, 'password')->passwordInput() ?>

      <!--   <?php
            /*
            if($model->getModel()->isNewRecord){
             //        <!-- attribute school_id -->
            echo  $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => ArrayHelper::map($model->getSchool(),'school_id','school_title'),
                   // 'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
            ]);
            }
            */
        ?> -->
      <!--   <?php
            /*
            $model->birth  =  isset($model->getModel()->userProfile->birth) ? $model->getModel()->userProfile->birth : '';
            $model->gender =  isset($model->getModel()->userProfile->gender) ? $model->getModel()->userProfile->gender : time();
            */
        ?> -->
         
        <!-- <?php /* $form->field($model, 'gender')->dropDownlist([
            UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
            UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
        ])*/ ?> -->
       <!--  <?php
        /* $form->field($model, 'birth')->widget(
                DateTimeWidget::className(),
                [
                    'locale'            => Yii::$app->language,
                    'phpDatetimeFormat' => 'yyyy-MM-dd',
                ]);*/
        ?> -->
        <?php echo $form->field($model, 'status')->dropDownList(User::statuses()) ?>
        <?php echo $form->field($model, 'roles')->checkboxList($roles) ?>
        <div class="form-group">
            <?php echo Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div>
