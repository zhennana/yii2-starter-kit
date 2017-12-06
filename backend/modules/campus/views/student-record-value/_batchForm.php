<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\campus\models\StudentRecordValue;
use trntv\yii\datetime\DateTimeWidget;


$this->title = Yii::t('backend', '创建学生成绩');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '成绩列表'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$schools = Yii::$app->user->identity->schoolsInfo;
$schools = ArrayHelper::map($schools,'school_id','school_title');

$grades = $data_user = [];
if (!$model->isNewRecord) {
    $grades =  Yii::$app->user->identity->gradesInfo;
    $grades  = ArrayHelper::map($grades,'grade_id','grade_name');

    $user = Yii::$app->user->identity->getGradeToUser($model->grade_id,10);
    foreach ($user as $key => $value) {
       if(!empty($value['realname'])){
            $data_user[$value['id']] = $value['realname'];
            continue;
       }
       if(!empty($value['username'])){
            $data_user[$value['id']] = $value['username'];
            continue;
       }
       if(!empty($value['phone_number'])){
            $data_user[$value['id']] = $value['phone_number'];
       }
   }
}
?>

<!-- <div class="error-summary alert alert-error" style=""></div> -->
<?php $form = ActiveForm::begin([
        'id'=> 'Course',
       // 'action'=>'',
]); ?>

    <!-- <?php // echo $form->errorSummary($model); ?> -->

<div class="col-md-12">
<!-- general form elements -->
    <div class="box box-primary box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?php
                 echo Yii::t('frontend',"创建成绩") ;?>
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
            </h4>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'school_id')->widget(Select2::className(),[
                'data' => $schools,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange('school_id',this.value,'#studentrecordvalue-grade_id');
                        handleChange('key',this.value,'#studentrecordvalue-student_record_key_id');
                        $('.results1').children().remove();
                    }"
                ]
            ]) ?>
        </div>
         <div class="col-lg-4">
            <?= $form->field($model, 'grade_id')->widget(Select2::className(),[
                'data' => $grades,
                'options'       => ['placeholder' => Yii::t('backend','请选择'),'closeOnSelect'=> false],
                'pluginOptions' => [

                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange('grade_id',this.value,'#studentrecordvalue-user_id');
                    }"
                ]
            ])->hint('') ?>
        </div>
         <div class="col-lg-4">
            <?= $form->field($model, 'user_id')->widget(Select2::className(),[
                'data' => $data_user,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])->hint(false) ?>
        </div>
        <div class="col-lg-12"></div>
        <div class="col-lg-4">
            <?= $form->field($model, 'exam_type')->widget(Select2::className(), [
                'data'=>StudentRecordValue::optsExamType(),
                'hideSearch' => true,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'student_record_key_id')->widget(Select2::className(), [
                'data'=>[],
                // 'hideSearch' => true,
                'options'       => ['placeholder' => Yii::t('backend','请选择'),'multiple'=>true],
                'pluginOptions' => [
                    'allowClear' => true,
                    'readonly' =>true,
                ],
                'showToggleAll'=>false,
                // 'toggleAllSettings'=>[
                //          'selectLabel'=>'',
                //          'unselectLabel'=>''
                // ],
                 'pluginEvents' => [
                    // "change" => "function() {
                    //     Changes(this.value);
                    // }",
                    // unselecting unselect
                    "select2:selecting"=>"function(e){
                        addInput(e.params.args.data.id,e.params.args.data.text);
                    }",
                    "select2:unselect"=>"function(e){
                        // console.log(e);
                         removeInput(e.params.data.id);
                    }"
                ]
            ]); ?>
        </div>
        <div class="results1">
        </div>
         <div  class="col-lg-12">
        <?php echo $form->errorSummary($model); ?>
         <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
 </div>
</div>

<script type="text/javascript">
    var key = <?php echo  json_encode($keys); ?>;
    function handleChange(type,value,form){
        $.ajax({
            "url":"<?php echo Url::to(['student-record-value/ajax-form'])?>",
            "data":{type:type,value:value},
            'type':"GET",
            'success':function(data){
                // console.log(data);
                 $(form).html(data);
            }
        }) 
    }
    function addInput(id,text){
        console.log(id);
        var string = '<div class="results-'+ id +'"';
        string += '><div class="col-lg-12"><h4>';
        string += text;
        string += '</h4></div>';
        string += '<div class="col-lg-6">';
        string += Joining(id,'total_score','总分');
        string += '</div><div class="col-lg-6">';
        string += Joining(id,'score','得分');
        string += '</div></div>';
        $(".results1").append(string);
 // console.log($('form'));
        $('form#Course').yiiActiveForm('add', {
                "id": 'studentrecordvalue-results-' + id +'-total_score',
                "name": '[results]['+ id +']total_score',
                "container": '.field-studentrecordvalue-results-'+ id +'-total_score',
                "input": '#studentrecordvalue-results-'+ id +'-total_score',
               // "error":".help-block",
                "value":"",
                "validate": function(attribute, value, messages, deferred, form) {
                    yii.validation.required(value, messages, { "message": "总分不能为空" });
                }
        });
        $('form#Course').yiiActiveForm('add', {
                "id": 'studentrecordvalue-results-'+ id +'-score',
                "name": '[results]['+ id +']score',
                "container": '.field-studentrecordvalue-results-'+ id +'-score',
                "input": '#studentrecordvalue-results-'+ id +'-score',
              //  "error":".help-block",
                "value":"",
                "validate": function(attribute, value, messages, deferred, form) {
                    yii.validation.required(value, messages, { "message": "得分不能为空" });
                }
        });

    }
    function removeInput(id){
        $(".results-"+id).remove();
        $('form').yiiActiveForm('remove', 'studentrecordvalue-results-'+ id +'-total_score');
        $('form').yiiActiveForm('remove', 'studentrecordvalue-results-'+ id +'-score');
    }
    //拼接dom
    function Joining(id,title,label){
        var titles = 'studentrecordvalue-results-'+ id +'-'+title;
        var name  = 'StudentRecordValue[results]['+ id +']['+ title +']';
        var string = '<div class="form-group field-'+titles+'">';
            string += '<label class="control-label" for="'+ titles +'">'+label+'</label>';
            string += '<input type="text" id="'+ titles+'" class="form-control" name="'+ name +'">';
            string += '<div class="help-block"></div></div>';
            return string;
    }
</script>