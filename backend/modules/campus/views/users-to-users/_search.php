<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\search\UsersToUsersSearch */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="users-to-users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'users_to_users_id') ?>

    <?php echo $form->field($model, 'user_left_id') ?>

    <?php echo $form->field($model, 'user_right_id') ?>

    <?php echo $form->field($model, 'status') ?>

    <?php echo $form->field($model, 'type') ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton(Yii::t('backend', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
