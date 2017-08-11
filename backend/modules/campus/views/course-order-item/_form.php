<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;

use common\models\User;
use backend\modules\campus\models\CourseOrderItem;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
* @var yii\widgets\ActiveForm $form
*/

 // $user      = User::find()->where(['status'=>2])->asArray()->all();
 // $data_user = ArrayHelper::map($user,'id','username');

?>

<div class="course-order-item-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'CourseOrderItem',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
<!-- attribute payment_id -->
            <?php if ($model->isNewRecord || \Yii::$app->user->can('manager')) {
                echo $form->field($model, 'payment_id')->textInput();
            }else{
                echo $form->field($model, 'payment_id')->textInput(['maxlength' => true, 'readonly' => true]);
            } ?>

<!-- attribute order_sn -->
            <?php if ($model->isNewRecord || \Yii::$app->user->can('manager')) {
                echo $form->field($model, 'order_sn')->textInput();
            }else{
                echo $form->field($model, 'order_sn')->textInput(['maxlength' => true, 'readonly' => true]);
            } ?>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          =>$schools ,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
                    'pluginEvents' => [
                        "change" => "function() {
                             handleChange(2,this.value,'#courseorderitem-user_id');
                        }",
                    ]
            ]) ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->widget(Select2::className(),[
                'data'              => $model->getList(2,$model->school_id),
                "maintainOrder"     => true,
                'options' => [
                    'placeholder' => '请选择'
                ],
                'pluginOptions' => [ 
                    'allowClear' => true
                ]
            ]); ?>

<!-- attribute total_course -->
            <?= $form->field($model, 'total_course')->textInput() ?>

<!-- attribute presented_course -->
            <?= $form->field($model, 'presented_course')->textInput() ?>
<!-- attribute coupon_price -->
            <?= $form->field($model, 'coupon_price')->textInput(['maxlength' => true]) ?>
<!-- attribute total_price -->
            <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>


<!-- attribute introducer_id -->
		<!-- 	<? /* $form->field($model, 'introducer_id')->widget(Select2::className(),[
                'data'              => $data_user,
                'options' => [
                    'placeholder' => '请选择'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]);*/ ?> -->

<!-- attribute payment -->
		<!-- 	<?/* $form->field($model, 'payment')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optPayment(),
                    'options'       => ['placeholder' => '请选择','value' => '200'],
                    'disabled' => true,
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); */?> -->
<!-- attribute payment_status -->
			<!-- <? /* $form->field($model, 'payment_status')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optPaymentStatus(),
                    'disabled' => true,
                    'options'       => ['placeholder' => '请选择', 'value' => '300'],
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);*/ ?>
 -->


<!-- attribute status -->
            <?= $form->field($model, 'status')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optStatus(),
                    'options'       => ['placeholder' => '请选择' ],
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('models', '课程订单'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton('<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('cruds', '创建') : Yii::t('cruds', '更新')),
        [
            'id'    => 'save-' . $model->formName(),
            'class' => 'btn btn-success'
        ]);
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<script>
    function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['course-order-item/ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
                 $(form).html(data);
            }
        }) 
    }
</script>

