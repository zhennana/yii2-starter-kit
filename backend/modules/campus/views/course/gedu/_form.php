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
use backend\modules\campus\models\CourseCategory;
use trntv\yii\datetime\DateTimeWidget;

$Courseware = Courseware::find()->where(['status'=>Courseware::COURSEWARE_STATUS_VALID])->asArray()->all();
$Courseware = ArrayHelper::map($Courseware,'courseware_id','title');

$schools = Yii::$app->user->identity->schoolsInfo;
$schools = ArrayHelper::map($schools,'school_id','school_title');

$parent = Course::find()->where(['parent_id' => 0,'status' => Course::COURSE_STATUS_OPEN]);
if ($model->isNewRecord) {
    $parents = $parent->asArray()->all();
}else{
    $parents = $parent->andWhere(['<>','course_id',$model->course_id])->asArray()->all();
}
$parents = ArrayHelper::map($parents,'course_id','title');

$categories = CourseCategory::find()->where(['status' => CourseCategory::STATUS_NORMAL])->asArray()->all();
$categories = ArrayHelper::map($categories,'category_id', 'name');
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

<!-- attribute parent_id -->
            <?= $form->field($model, 'parent_id')->widget(Select2::ClassName(),[
                    'data'          => $parents,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
            ]) ?>

<!-- attribute category_id -->
            <?= $form->field($model, 'category_id')->widget(Select2::ClassName(),[
                    'data'          => $categories,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
            ]) ?>

<!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => $schools,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ],
            ]) ?>

<!-- attribute banner_src -->
            <?= $form->field($model, 'banner_src')->textInput(['maxlength' => true]) ?>

<!-- attribute intro -->
            <?= $form->field($model, 'intro')->textArea(['maxlength' => true]) ?>

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
<!-- attribute original_price -->
            <?= $form->field($model, 'original_price')->textInput(['maxlength' => true]) ?>

<!-- attribute present_price -->
            <?= $form->field($model, 'present_price')->textInput(['maxlength' => true]) ?>

<!-- attribute vip_price -->
            <?= $form->field($model, 'vip_price')->textInput(['maxlength' => true]) ?>

<!-- attribute status -->
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
<!-- attribute access_domain -->
            <?= $form->field($model, 'access_domain')
                ->widget(Select2::className(),
                [
                    'data'          => Course::optsPrice(),
                    'hideSearch'    => true,
                    // 'options'       => ['placeholder'=>'请选择课件'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]);
            ?>

<!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>

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
                //console.log($('#course-teacher_id').val());
                $('#course-teacher_id options').remove();
                $(form).html(data);
            }
        })
    }
</script>
