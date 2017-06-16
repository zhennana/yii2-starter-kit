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
                            'data'=>UserToSchool::optsUserType()
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
                        ])
                ?>
        </div>
        
          <div class="col-lg-3">
                <?=
                    $form->field($model, 'grade_user_type')  
                        ->widget(Select2::className(),
                        [
                            'data'=>UserToGrade::optsUserType()
                        ])->label('班级职称');
                ?>
        </div>
        <div class="col-lg-12">

                <?=
                    $form->field($model, 'body')->textArea(['rows' => 10,'maxlength' => true,])->hint('用户名 手机号 邮箱以空格隔开
                        每条数据已换行隔开
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
            }
        }) 
    }
</script>