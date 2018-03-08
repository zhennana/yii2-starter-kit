<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use common\models\User;
use backend\modules\campus\models\School;
use backend\modules\campus\models\ActivationCode;
use trntv\yii\datetime\DateTimeWidget;
/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\ActivationCode */
/* @var $form yii\bootstrap\ActiveForm */
if($model->isNewRecord){
    $model->activation_code = $model->randomStr(6);
}

$users = User::find()->active()->asArray()->all();
$users = ArrayHelper::map($users,'id','username');

$schools = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
$schools = ArrayHelper::map($schools, 'id', 'school_title');
?>

<div class="activation-code-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'ActivationCodeForm',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'activation_code')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>

    <?= $form->field($model, 'school_id')->widget(Select2::className(),[
                'data'    => $schools,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::className(),[
                'data'    => $users,
                'options' => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
            ]); ?>

    <?= $form->field($model, 'payment')->widget(Select2::className(),[
        'data'          => ActivationCode::optsPayment(),
        'hideSearch'    => true,
        'options'       => ['placeholder' => '请选择'],
        'pluginOptions' => [ 
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'status')->widget(Select2::className(),[
        'data'          => ActivationCode::optsStatus(),
        'hideSearch'    => true,
        'options'       => ['placeholder' => '请选择'],
        'pluginOptions' => [ 
            'allowClear' => true,
        ],
    ]); ?>

    <?php echo $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'coupon_type')->widget(Select2::className(),[
        'data'          => ActivationCode::optsCoupon(),
        'options'       => ['placeholder' => '请选择'],
        'hideSearch'    => true,
        'pluginOptions' => [ 
            'allowClear' => true,
        ],
    ]); ?>
    <?php echo $form->field($model, 'coupon_price')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'real_price')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'expired_at')
                ->widget(
                    DateTimeWidget::className(),
                    [
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'yyyy-MM-dd HH:mm',
                        'momentDatetimeFormat' => 'YYYY-MM-DD HH:mm',
                    ])
            ?>

    </p>
    <?php $this->endBlock(); ?>
    <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '兑换码'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>

        <hr/>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

    <?php ActiveForm::end(); ?>

</div>
