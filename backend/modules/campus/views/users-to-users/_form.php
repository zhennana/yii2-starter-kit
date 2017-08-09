<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\modules\campus\models\UsersToUsers;
use backend\modules\campus\models\UserToSchool;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UsersToUsers */
/* @var $form yii\bootstrap\ActiveForm */
$user_right_id = $model->getOtherUsers();

$school_id = Yii::$app->user->identity->currentSchoolId;
$user_left_id = Yii::$app->user->identity->getSchoolToUser($school_id,UserToSchool::SCHOOL_USER_TYPE_STUDENTS);
$data = [];
foreach ($user_left_id as $key => $value) {
   if(!empty($value['realname'])){
        $value['name'] = $value['realname'];
        $data[] = $value;
        continue;
   }
   if(!empty($value['username'])){
        $value['name'] = $value['username'];
   }
   $data[] = $value;
}
$user_left_id = ArrayHelper::map($data,'id','name');
?>

<div class="users-to-users-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'UsersToUsers',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <!-- attribute user_left_id -->
    <?= $form->field($model, 'user_left_id')
        ->widget(Select2::className(),
        [
            'data'          => $user_left_id,
            'options'       => ['placeholder' => '请选择'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>

    <!-- attribute user_right_id -->
    <?= $form->field($model, 'user_right_id')
        ->widget(Select2::className(),
        [
            'data'          => $user_right_id,
            'options'       => ['placeholder' => '请选择'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>

    <!-- attribute type -->
    <?= $form->field($model, 'type')
        ->widget(Select2::className(),
        [
            'data'          => UsersToUsers::optsType(),
            'hideSearch'    => true,
            'options'       => ['placeholder'=>'请选择'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>

    <!-- attribute status -->
    <?= $form->field($model, 'status')
        ->widget(Select2::className(),
        [
            'data'          => UsersToUsers::optsStatus(),
            'hideSearch'    => true,
            'options'       => ['placeholder'=>'请选择'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
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
