<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use trntv\yii\datetime\DateTimeWidget;

// var_dump($model1);exit;
$this->title = Yii::t('backend', '排课时间对换');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '排课'), 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
$course_schedule_ids = ArrayHelper::map($course_model,'course_schedule_id','title');
 $course_models = ArrayHelper::index($course_model,'course_schedule_id');
$course_model_json = json_encode($course_models,JSON_UNESCAPED_UNICODE);
 // var_dump($course_model_json);
?>

<!-- <div class="error-summary alert alert-error" style=""></div> -->
 <?php $form = ActiveForm::begin([
    'id' => 'CourseSchedule',
    //'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>
<div class="col-md-12">
<!-- general form elements -->
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php
                 echo Yii::t('frontend',"排课时间对换") ;?>
            </h3>

            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool" type="button"> <i class="fa fa-minus"></i>
                </button>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
        </div>

    <div class="box-body">
         <div class = "col-lg-3">
             <?= $form->field($original_model, '[0]course_schedule_id')->widget(Select2::className(),
                 [
                    'data'          => [$original_model->course_schedule_id =>$original_model->course->title],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                    ]
            ])->label('原课程名'); ?> 
        </div>
        <div class = "col-lg-3">
             <?= $form->field($original_model, '[1]which_day')->widget(Select2::className(),
                [
                    'data'          => [$original_model->which_day =>$original_model->which_day],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->label('原日期')->hint(false); ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($original_model, '[1]start_time')->widget(Select2::className(),
                [
                    'data'          => [$original_model->start_time=>$original_model->start_time],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->label('原上课开始时间')->hint(false); ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($original_model, '[1]end_time')->widget(Select2::className(),
                [
                    'data'          => [$original_model->end_time=>$original_model->end_time],

                    'options'       => ['placeholder' => '请选择', 'readOnly'=>true,],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->label('原上课结束时间')->hint(false); ?>
        </div>
        <br>
        <div class = "col-lg-12"></div>

      <div class = "col-lg-3">
            <?= $form->field($new_model, '[1]course_schedule_id')->widget(Select2::className(),
                [
                    'data'          => $course_schedule_ids,
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                    ],
                    'pluginEvents' => [
                        "change" => "function() {
                            handleChange(1,this.value,'#courseschedule-0-which_day');
                            handleChange(2,this.value,'#courseschedule-0-end_time');
                            handleChange(3,this.value,'#courseschedule-0-start_time');
                        }",
                    ]
            ])->label('课程名'); ?>
        </div>
        <div class = "col-lg-3">
             <?= $form->field($new_model, '[0]which_day')->widget(Select2::className(),
                [
                    'data'          => [],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->label('日期')->hint(false); ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($new_model, '[0]start_time')->widget(Select2::className(),
                [
                    'data'          => [],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->hint(false); ?>
        </div>
        <div class = "col-lg-3">
            <?= $form->field($new_model, '[0]end_time')->widget(Select2::className(),
                [
                    'data'          => [],
                    'options'       => ['placeholder' => '请选择','readOnly'=>true],
                    'pluginOptions' => [
                        'allowClear' => false,
                ]
            ])->hint(false); ?>
        </div>

        <div class  = "col-lg-3">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> ' .
                Yii::t('backend', '提交'),
                [
                    'id'    => 'back',
                    'class' => 'btn btn-success'
                ]
            ); ?>
        </div>
         <?php ActiveForm::end(); ?>
    </div>
    <div id = "message"></div>
    <div id = "schedule_record"></div>
 </div>
    </div>

<script>
    var data = <?php echo $course_model_json  ?>;
    console.log(data);
    function handleChange(type,id,form){
        if(type ==1 ){
            if(data[id]){
              var  string =  "<option value="+ data[id].which_day + ">" + data[id].which_day +"</option>";
              $(form).html(string);
            }
        }
        if(type ==2){
            if(data[id]){
                var  string =  "<option value="+ data[id].end_time + ">" + data[id].end_time +"</option>";
               $(form).html(string);
            }
        }
        if(type ==3){
             if(data[id]){
                var  string =  "<option value="+ data[id].start_time + ">" + data[id].start_time +"</option>";
                $(form).html(string);
            }
        }
    }
</script>