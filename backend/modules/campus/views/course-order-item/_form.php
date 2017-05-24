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

$user      = User::find()->where(['status'=>2])->asArray()->all();
$data_user = ArrayHelper::map($user,'id','username');

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
            

<!-- attribute course_order_item_id -->
            <?= $form->field($model, 'course_order_item_id')->textInput() ?>

<!-- attribute parent_id -->
			<?= $form->field($model, 'parent_id')->textInput() ?>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => $model->getlist(),
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
                    'pluginEvents' => [
                        "change" => "function() {
                             handleChange(1,this.value,'#courseorderitem-grade_id');
                        }",
                    ]
            ]) ?>

<!-- attribute grade_id -->
			<?= $form->field($model, 'grade_id')->widget(Select2::className(),
                [
                    'data'          => $model->getlist(1,$model->school_id),
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>

<!-- attribute user_id -->
			<?= $form->field($model, 'user_id')->widget(Select2::className(),[
                'data'              => $data_user,
                "maintainOrder"     => true,
                'options' => [
                    'placeholder' => '请选择'
                ],
                'pluginOptions' => [ 
                    'allowClear' => true
                ]
            ]); ?>

<!-- attribute introducer_id -->
			<?= $form->field($model, 'introducer_id')->widget(Select2::className(),[
                'data'              => $data_user,
                'options' => [
                    'placeholder' => '请选择'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>

<!-- attribute payment -->
			<?= $form->field($model, 'payment')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optPayment(),
                    'options'       => ['placeholder' => '请选择'],
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>

<!-- attribute payment_status -->
			<?= $form->field($model, 'payment_status')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optPaymentStatus(),
                    'options'       => ['placeholder' => '请选择'],
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>

<!-- attribute total_course -->
			<?= $form->field($model, 'total_course')->textInput() ?>

<!-- attribute presented_course -->
            <?= $form->field($model, 'presented_course')->textInput() ?>

<!-- attribute total_price -->
            <?= $form->field($model, 'total_price')->textInput(['maxlength' => true]) ?>

<!-- attribute coupon_price -->
			<?= $form->field($model, 'coupon_price')->textInput(['maxlength' => true]) ?>

<!-- attribute real_price -->
            <?= $form->field($model, 'real_price')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->widget(Select2::className(),
                [
                    'data'          => CourseOrderItem::optStatus(),
                    'options'       => ['placeholder' => '请选择'],
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

