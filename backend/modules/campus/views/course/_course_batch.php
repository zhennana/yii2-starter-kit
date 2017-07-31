<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use trntv\yii\datetime\DateTimeWidget;


$this->title = Yii::t('backend', '排课');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学校人员管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump(time());exit;


 $model->school_id = 29;
$model->grade_id  = 22;
$model->category_id = 3;
$model->teacher_id = 1;
$model->start_times = 1501237313;
$model->start_date = time();
$model->end_times  = (1501237313+ 60*60);
$model->which_day  = 1;
?>

<!-- <div class="error-summary alert alert-error" style=""></div> -->
<?php $form = ActiveForm::begin([
        'id'=> 'Course',
       // 'action'=>'',
]); ?>
<div class="col-md-12">
<!-- general form elements -->
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php
                 echo Yii::t('frontend',"排课") ;?>
            </h3>

            <div class="box-tools pull-right">
                <button data-widget="collapse" class="btn btn-box-tool" type="button"> <i class="fa fa-minus"></i>
                </button>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
        </div>

    <div class="box-body">
        <div class="col-lg-12">
            <h4>
                排课逻辑：
            </h4>
            <p>
                老师排课时间冲突：直接覆盖与本老师有关的课程(包括其他班级的课程)<br>
                班级排课时间冲突：直接覆盖未上完的课程<br>
            </p>
        </div>
        <div class="col-lg-3">
               <?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => $schools,
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
        </div>
         <div class="col-lg-3">
            <?= $form->field($model, 'grade_id')->widget(Select2::className(),
                [
                    'data'          => $model->getlist(1,$model->school_id),
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents' => [
                        "change" => "function() {
                            handleChange(2,this.value,'#course-teacher_id');

                        }",
                    ]
            ]); ?>
        </div>
         <div class="col-lg-3">
            <?= $form->field($model, 'category_id')->widget(Select2::className(),
                [
                    'data'          => $categorys,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
            ])->label('课件分类'); ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'course_schedule_id')->widget(Select2::className(),
                [
                    'data'          => [],
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
            ])->label('已排过的课程'); ?>
        </div> 
        <div  class="col-lg-12"></div>
        <div class="col-lg-3">
            <?= $form->field($model, 'start_date')->widget(
                    DateTimeWidget::className(),
                    [
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'yyyy-MM-dd'
                    ]
            )->label('课程开始时间') ?>
        </div>

        <div class="col-lg-3">
            <?= $form->field($model, 'which_day')->widget(Select2::className(),
                [
                    'data'          => [
                                1=>'周一',
                                2=>'周二',
                                3=>'周三',
                                4=>'周四',
                                5=>'周五',
                                6=>'周六',
                                7=>'周日'
                    ],
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
            ])->label('周几'); ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'start_times')->widget(
                    DateTimeWidget::className(),
                    [
                        'locale'            => Yii::$app->language,
                        'phpDatetimeFormat' => 'HH:mm',
                        'momentDatetimeFormat' => 'HH:mm',

                    ]
            )->label('上课开始时间') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'end_times')->widget(
                    DateTimeWidget::className(),
                    [
                        'locale'            => Yii::$app->language,
                        'momentDatetimeFormat' => 'HH:mm',
                        'phpDatetimeFormat' => 'HH:mm',
                    ]
            )->label('上课结束时间') ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'teacher_id')->widget(Select2::className(),
                [
                    'data'          => $model->getlist(2,$model->grade_id),
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
        </div>
        <div class="col-lg-3">
            <div></div><br>
             <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('backend', '查看排课'),
            [
                'id'    => 'paicha',
                'class' => 'btn btn-success'
            ]
        ); ?>
        </div>
        <div class  = "col-lg-12"></div>
        <div class  = "col-lg-3">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> ' .
                Yii::t('backend', '提交排课'),
                //[''],
                [
                    'id'    => 'commit',
                    'class' => 'btn btn-success'
                ]
            ); ?>
        
        </div>
        <div class  = "col-lg-3">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-check"></span> ' .
                Yii::t('backend', '返回'),
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
    function createTable(data) {

        function trans(b) {
            return b ? "是" : "否";
        }
        // 创建表格
        var table = $("<table border=\"1\">");
        var tr1 = $("<tr></tr>");
        var tr1_td_new = $("<td colspan=\"4\">新排课</td>");
        var tr1_td_old = $("<td colspan=\"4\">旧排课</td>");

        tr1_td_new.appendTo(tr1);
        tr1_td_old.appendTo(tr1);
        $("<td colspan=\"2\"></td>").appendTo(tr1);
        tr1.appendTo(table);


        var tr2 = $("<tr></tr>");

        var tr1_td_conflict = $("<td colspan=\"1\">是否冲突</td>");
        var tr1_td_override = $("<td colspan=\"1\">是否可覆盖</td>");

        $("<td colspan=\"1\">教师</td>").appendTo(tr2);
        $("<td colspan=\"1\">班级</td>").appendTo(tr2);
        $("<td colspan=\"1\">排课</td>").appendTo(tr2);
        $("<td colspan=\"1\">日期</td>").appendTo(tr2);

        $("<td colspan=\"1\">教师</td>").appendTo(tr2);
        $("<td colspan=\"1\">班级</td>").appendTo(tr2);
        $("<td colspan=\"1\">排课</td>").appendTo(tr2);
        $("<td colspan=\"1\">日期</td>").appendTo(tr2);


        tr1_td_conflict.appendTo(tr2);
        tr1_td_override.appendTo(tr2);


        tr2.appendTo(table);

        var trs = [];
        for (var i = 0; i < data.length; i++) {
            trs[i] = $("<tr></tr>");
           //console.log(trs[i]);
           // console.log(data[i]);
            $("<td colspan=\"1\">" + (data[i].NewRecord.teacher_name ?data[i].NewRecord.teacher_name :'')   + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].NewRecord.grade_name  ?data[i].NewRecord.grade_name :'')  + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].NewRecord.course  ? data[i].NewRecord.course :'')  + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].NewRecord.time  ? data[i].NewRecord.time:'' ) + "</td>").appendTo(trs[i]);

            $("<td colspan=\"1\">" + (data[i].OldRecord.teacher_name  ? data[i].OldRecord.teacher_name  : '') + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].OldRecord.grade_name ?data[i].OldRecord.grade_name:'' )
                + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].OldRecord.course ?data[i].OldRecord.course :'') + "</td>").appendTo(trs[i]);
            $("<td colspan=\"1\">" + (data[i].OldRecord.time 
                ? data[i].OldRecord.time : '') + "</td>").appendTo(trs[i]);

            var aa = $("<td colspan=\"1\">" + trans(data[i].isConflict) + "</td>");
            if (data[i].isConflict) {
                aa.css('color', 'red');
            } else {
                aa.css('color', 'green');
            }

            var bb = $("<td colspan=\"1\">" + trans(data[i].override) + "</td>");

            if (data[i].override) {
                bb.css('color', 'red');
            } else {
                bb.css('color', 'green');
            }

            aa.appendTo(trs[i]);
            bb.appendTo(trs[i]);
            trs[i].appendTo(table);
        }
        table.css('text-align', 'center').css('border-collapse', 'collapse');
        table.appendTo($('#schedule_record'));
    }
    var submit_data;
    var delete_record;
//CourseValidations
    $(document).ready(function () {
        $('body').on('beforeSubmit','form#Course', function () {
            var form = $('form');
            // return false if form still have some validation errors
            if (form.find('.has-error').length)
            {
                return false;
            }
            // submit form
            $.ajax({
            url    : '<?php echo  Url::to(['course-validations']) ?>',
            type   : 'POST',
            data   : form.serialize(),
            success: function (response)
            {
                console.log(response);
                var message = response.message;
                 submit_data = response.NewRecord;
                 delete_record = response.DeleteRecord;
                // console.log(submit_data,message);
                $('#schedule_record table').remove();
                $('#message').empty();
                if(response.is_commit == true){
                    //$('#paicha').attr('disabled',"true");
                    $('#schedule_record table').remove();
                    $('#commit').show();
                    $('#paicha').hide();
                    $('#message').show();
                    $('#back').show();
                    $('#message').append(response.schedule_count +response.schedule_start_time) ;
                    //$('from').find('input','select').attr('disabled',true);
                    //NotChoose();
                    createTable(message);
                }else{
                    var message = response.message;
                    $('#back').show();
                    $('#paicha').hide();
                    $('#message').append('本次排课有致命冲突无法排课,详情请查看下边表格');
                    createTable(message);
                }
            },
            error  : function ()
            {
               alter('网络错误');
            }
            });
            return false;
         });
    });
   $($("#commit")[0]).on('click',function(event){
         $('#commit').hide();
         $('#back').hide();
         $.ajax({
            url    : '<?php echo  Url::to(['course-batch']) ?>',
            type   : 'POST',
            data   : {Course:submit_data,DeleteRecord:delete_record},
            success: function (response)
            {
                alert('排课成功');
               $('#back').show();
            }
        });
        return false;
    });
    $("#back").on('click',function(){
        $('#paicha').show();
        $('#back').hide();
        $('#commit').hide();
        $('#schedule_record table').remove();
        $('#message').empty();
        return false;
    }

        );

</script>
 <style>
        #schedule_record td {
            padding: 5px;
            min-width: 100px;
        }
        #commit,#back {
            display: none;
        }
</style>