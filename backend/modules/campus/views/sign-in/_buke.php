<?php

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\SignIn;
use common\models\User;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
* @var yii\widgets\ActiveForm $form
*/

?>

<div class="sign-in-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'SignIn',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            <!-- attribute student_id -->
            <?= $form->field($model, 'student_id')->widget(Select2::className(),[
                'data' =>[$model->student_id =>Yii::$app->user->identity->getUserName($model->student_id)],
                'options'=>['placeholder'=>'请选择'],
            ])->label('补课学员') ?>
<!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->widget(Select2::className(),
                [
                    'data'=>[$model->school_id =>$model->school->school_title],
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> false,
                    ],
                ]); ?>
            <?= $form->field($model,'signin_id') ?>
            <?= $form->field($model, 'grade_id')->widget(Select2::className(),
                [
                    'data'=>$model->getlist(2,$model->school_id),
                    'options'=>['placeholder'=>'请选择'],
                    'pluginOptions'=>[
                        'allowClear'=> true,
                    ],
                    'pluginEvents'=>[
                        "change" => "function() {
                            handleChange(courseware_id,this.value);
                         }",
                    ]
                ]); ?>

<!-- attribute course_id -->
            <!-- <? //= /*$form->field($model, 'course_id')->widget(Select2::className(),
                [
                    // 'data'=>[],
                    // 'options'=>['placeholder'=>'请选择'],
                    // 'pluginOptions'=>[
                    //     'allowClear'=> true,
                    // ],
                    // 'pluginEvents'=>[
                    //      "change" => "function() {
                    //           handleChange(4,this.value,'#signin-student_id');
                    //      }",
                    ]
                //])->label('补课课程课程');*/ ?> -->
            <div class="form-group field-signin-course_title">
                <label class="control-label col-sm-3" for="signin-course_title">课程名</label>
                <div class="col-sm-6">
                <input type="text" id="signin-course_title" class="form-control" name="SignIn[course_title]">
                </div>
            </div>
            <div class="form-group field-signin-teacher_id">
                <label class="control-label col-sm-3" for="signin-teacher_id">课程名</label>
                <div class="col-sm-6">
                <input type="text" id="signin-teacher_id" class="form-control" name="SignIn[signin_title]">
                </div>
            </div>
           <!--   <? //= $form->field($model,'course_id')->label('课程')?> -->
             <!-- <? // = $form->field($model,'course_schedule_id')->label('排课id') ?> -->

            <?= $form->field($model, 'teacher_id')->widget(Select2::className(),[
                    'data' =>[],
                    'options'=>['placeholder'=>'请选择'],]
            ) ?>
            <input type="" name="" value = "<?php echo $model->signin_id ?>">
            <input type=""  name="" value = '' >
        </p>

        <?php $this->endBlock(); ?>

        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [
                [
                    'label'   => ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '跟班补课')),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
        ]); ?>

        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('models', '创建') : Yii::t('models', '更新')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script>
    var courseware_id = "<?php echo $model->course->courseware_id ?>";
    // console.log(courseware_id);
    function handleChange(courseware_id,id){
        $.ajax({
            "url":"<?php echo Url::to(['ajax-buke'])?>",
            "data":{courseware_id:courseware_id,grade_id:id},
            'type':"GET",
            'success':function(data){
                console.log(data);
            }
        }) 
    }
</script>
