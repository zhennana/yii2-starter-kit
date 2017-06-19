<?php
    use yii\widgets\ActiveForm;
?>

    <?php $form = ActiveForm::begin(); ?>
        <?php
            echo $form->field($activityToUsers, 'phone_string')
            ->textarea(['rows' => 10,'maxlength' => true]);
         
            $activityToUsers->status = 1;
            echo $form->field($activityToUsers, 'status')
            ->checkbox()->hint(Yii::t('frontend','Select the invitations'));

             $activityToUsers->is_smsc_status = 1;
            echo $form->field($activityToUsers, 'is_smsc_status')
            ->checkbox()->hint(Yii::t('frontend','Select SMS'));

            $activityToUsers->is_wechat_stauts = 1;
            echo $form->field($activityToUsers, 'is_wechat_stauts')
            ->checkbox()->hint(Yii::t('frontend','Focus on the binding WeChat user can accept'));
        ?>

        <div class="form-group">
        <?php 
        echo Html::submitButton(
            $activityToUsers->isNewRecord ? Yii::t('frontend', 'Invite') : Yii::t('frontend', 'Update'),
        ['class' => $activityToUsers->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);

        ?> 