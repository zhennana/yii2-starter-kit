<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;
use common\models\UserForm;

$userToGrade = new UserToGrade;
$school = Yii::$app->user->identity->schoolsInfo;
$school = ArrayHelper::map($school,'school_id','school_title');
// echo'<pre>';
// var_dump(Yii::$app->authManager->getPermissionsByUser(6));
// //var_dump(Yii::$app->authManager->getChildRoles('leader'));exit;
//  var_dump('<pre>',$rules);exit;
?>

<?php $form = ActiveForm::begin([
            'id'=>'123']
); ?>
<div class="col-md-12">
<!-- general form elements -->
<div class="box box-primary box-solid">
    <div class="box-header with-border">
        <h3 class="box-title"><?php
             echo Yii::t('frontend',"创建新学员") ;
        ?></h3>
        <div class="box-tools pull-right">
            <button data-widget="collapse" class="btn btn-box-tool" type="button"> <i class="fa fa-minus"></i>
            </button>
        </div>

        <!-- /.box-header -->
        <!-- form start -->
    </div>
    <div class="box-body">
    <div>
        如何导入新学员：<br>

           1 没有开过账号的用户会直接开户。密码是手机号后六位。并与学校/班级产生创建关系（学校必选，这里可以不用选择班级,之后可以去班级人员管理分班）。<br>
           2 开过账号的学员会直接更新用户信息。如果选择了班级那么会检测用户是否已经存在班级(一个学员只能有一个班级)<br>
           3 如果选择了班级，并且班级职称是 学生会先检测用户是否缴费。如果未缴费会提示你,并只会与学校产生关系。并不会与班级产生关系。
           4 所有用户在学校下边都是学员。
    </div>
    <?php
    if(isset($info) && !empty($info)){
        //dump($info);
         echo "<div class='error-summary alert alert-error'>";
         echo "<p>错误警告：</p>";
         echo "<ul>";
        foreach ($info as $key => $value) {
           if(isset($value) && is_array($value)){
                foreach ($value as $k => $v) {
                  if(is_string($v)){
                    echo "<li style='padding:0 3px'>".$v."</li>";
                  }
                  if(is_array($v)){
                    foreach ($v as  $v1) {

                        if(is_string($v1)){
                            //var_dump($v1);
                            echo "<li style='padding:0 3px'>".$v1."</li>";
                        }
                    }
                  }
                }
           }
        }
         echo "</ul>";
         echo "</div>";
    }
?>
        <div class="col-lg-3">
                <?=
                    $form->field($model, 'school_id')->widget(Select2::className(),
                        [
                            'data' =>$school,
                            'pluginOptions'=>[
                                'allowClear'=> true,
                            ],
                            'options'=>[
                                'placeholder'=>'请选择学校',
                            ],
                            'pluginEvents' => [
                                "change" => "function() {
                                    handleChange(1,this.value,'#usertoschoolform-grade_id');
                    }"
                ]
                        ])

                    //->textInput(['maxlength' => true])
                ?>
        </div>
        <div class="col-lg-3">
                <?=
                    $form->field($model, 'school_user_type')
                        ->widget(Select2::className(),
                        [
                            'data'=>UserToSchool::optsUserType(),
                             'options'=>[
                                'placeholder'=>'请选择学校',
                            ],
                            'pluginEvents' => [
                                "change" => "function() {
                                    // if(this.value == 10){
                                    //     $('#usertoschoolform-grade_user_type').html('<options  value= 10 >学生</option>');
                                    // }else{
                                    //     $('#usertoschoolform-grade_user_type').html('<option  value= 20 >老师</option>');
                                    // }
                            }"
                        ],
                        ])->label('学校职称');
                ?>
        </div>
        <div class="col-lg-3">
                <?=

                //var_dump('<pre>',$userToGrade->getlist(1,1));exit;
                 $form->field($model, 'grade_id')->widget(Select2::className(),
                        [
                            'data' => $userToGrade->getlist(1,$model->school_id),
                            'pluginOptions'=>[
                                'allowClear'=> true,
                            ],
                            'options'=>[
                                'placeholder'=>'请选择班级',
                            ],
                        ])
                ?>
        </div>
        
          <div class="col-lg-3">
                <?=
                    $form->field($model, 'grade_user_type')  
                        ->widget(Select2::className(),
                        [
                            'data'=>UserToGrade::optsUserType(),
                        ])->label('班级职称');
                ?>
        </div>
        <div class="col-lg-12">

                <?=
                    $form->field($model, 'body')->textArea(['rows' => 10,'maxlength' => true,])->hint('用户名 手机号 邮箱以空格隔开
                        每个用户信息已空格 隔开
                     ');
                ?>
                 <?php echo $form->field($model, 'roles')->checkboxList($rules) ?>
                 <?=    $form->errorSummary($model); ?>
                 <?= Html::submitButton(
                    '<span class="glyphicon glyphicon-check"></span> ' .
                    Yii::t('backend', '创建'),
                    [
                        'id'    => 'save-' . $model->formName(),
                        'class' => 'btn btn-success'
                    ]);
                ?>

        </div>
   
    </div>
 </div>
 
</div>
<?php ActiveForm::end(); ?>
<script>
    function handleChange(type_id,id,form){
        $.ajax({
            "url":"<?php echo Url::to(['user-to-grade/ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
              
               $(form).html(data);
               // $("div").remove("#father div"); 
            // console.log($('#select2-usertoschoolform-grade_id-results'));
            }
        }) 
    }
</script>