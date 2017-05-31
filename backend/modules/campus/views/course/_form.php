<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use backend\modules\campus\models\Courseware;
use backend\modules\campus\models\Course;
use trntv\yii\datetime\DateTimeWidget;

$Courseware = Courseware::find()->where(['status'=>Courseware::COURSEWARE_STATUS_VALID])->asArray()->all();
$Courseware = ArrayHelper::map($Courseware,'courseware_id','title');
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
* @var yii\widgets\ActiveForm $form
*/
// var_dump($model->getlist());exit;
?>

<div class="course-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'Course',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => $model->getlist(),
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
                    'pluginEvents' => [
                        "change" => "function() {
                             handleChange(1,this.value,'#course-grade_id');
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

<!-- attribute intro -->
			<?= $form->field($model, 'intro')->textInput(['maxlength' => true]) ?>

<!-- attribute courseware_id -->
			<?= $form->field($model, 'courseware_id')
                ->widget(Select2::className(),
                [
                    'data'          => $Courseware,
                    'options'       => ['placeholder' => '请选择课件'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
            ?>
            <?php if($model->isNewRecord){
                    $model->start_time = time()+20;
                    $model->end_time   = time()+40*60;
            } ?> 
<!-- attribute start_time -->
            <?php echo $form->field($model, 'start_time')
                ->widget(
                    DateTimeWidget::className(),
                    [
                        //'clientOptions' => ,
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                        //'phpDatetimeFormat' => 'yyyy-MM-dd',
                    ]) 
            ?>
<!-- attribute end_time -->
            <?php echo $form->field($model, 'end_time')
                ->widget(
                    DateTimeWidget::className(),
                    [
                        //'clientOptions' => ,
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'yyyy-MM-dd\'T\'HH:mm:ssZZZZZ',
                        //'phpDatetimeFormat' => 'yyyy-MM-dd',
                    ]) 
            ?>
<!-- attribute status -->
			<!-- attribute courseware_id -->
            <?= $form->field($model, 'status')
                ->widget(Select2::className(),
                [
                    'data'          => Course::optsStatus(),
                    'hideSearch'    => true,
                    // 'options'       => ['placeholder'=>'请选择课件'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
            ?>

        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [ 
                [
                    'label'   => Yii::t('backend', '课程管理'),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '保存')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script>
    function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['course/ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
                 $(form).html(data);
            }
        }) 
    }
</script>
