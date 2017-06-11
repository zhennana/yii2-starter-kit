<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;

use backend\modules\campus\models\Notice;
use backend\modules\campus\models\UserToGrade;
use common\models\User;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Notice $model
* @var yii\widgets\ActiveForm $form
*/

$category = isset($_GET['category']) ? $_GET['category'] : $model->category;

if ($category == Notice::CATEGORY_TWO) {
    $data = [];
    $receivers = UserToGrade::getStudents()->getModels();
    foreach ($receivers as $key => $value) {
        if($value->user){
            $data[$value->user->id] = $value->user->username;
        }
    }
    $receivers = $data;
}else{
    $receivers = User::find()->where([
        'status' => User::STATUS_ACTIVE
    ])->asArray()->all();
    $receivers = ArrayHelper::map($receivers,'id','username');
}


?>

<div class="notice-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'Notice',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
<!-- attribute category -->
            <?= $form->field($model, 'category')->textInput()->hiddenInput([
                'value' => $category
                ])->label(FALSE)->hint(FALSE) ?>

<!-- attribute title -->
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute message -->
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

<!-- attribute sender_id -->
            <?= $form->field($model, 'sender_id')->textInput()->hiddenInput([
                'value' => Yii::$app->user->id
                ])->label(FALSE)->hint(FALSE) ?>

<!-- attribute receiver_id -->
            <?php
        if($model->isNewRecord){
            echo $form->field($model, 'receiver_id')->widget(Select2::className(),[
                // 'language'          => 'en',
                // 'showToggleAll'     => true,
                'data'              => $receivers,
                'theme'             => Select2::THEME_BOOTSTRAP,
                "maintainOrder"     => true,
                'toggleAllSettings' => [
                    'selectLabel'   => '<i class="glyphicon glyphicon-unchecked"></i> 全选',
                    'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>取消全选'
                ],
                'options' => [
                    'placeholder' => '请选择',
                    'multiple'    => true,
                ],
                'pluginOptions' => [ 
                    'allowClear' => true 
                ]
            ]);
        }else{
            echo $form->field($model, 'receiver_id')->widget(Select2::className(),[
                'data'     => $receivers,
                'disabled' => true
            ]);
        }

    ?>

<!-- attribute is_wechat_message -->
            <?php //echo $form->field($model, 'is_wechat_message')->textInput() ?>

<!-- attribute status_send -->
            <?= $form->field($model, 'status_send')->dropDownList($model->optsStatusSend()) ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '消息管理'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ]]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

