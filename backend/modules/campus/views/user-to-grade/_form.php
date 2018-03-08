<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;

use common\models\User;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
* @var yii\widgets\ActiveForm $form
*/
$status =  UserToGrade::optsStatus();
unset($status[UserToGrade::USER_GRADE_STATUS_CHANGE]);
// var_dump($model->grade_user_type);exit;
    $grade_user_type =$model->grade_user_type;
    if(isset($_GET['grade_user_type'])){
        $grade_user_type = (int)$_GET['grade_user_type'];
    }
    $school_id = Yii::$app->user->identity->currentSchoolId;
    $currentSchool =  [Yii::$app->user->identity->currentSchool];
    $currentSchool = ArrayHelper::map($currentSchool,'school_id','school_title');

    if($grade_user_type == UserToGrade::GRADE_USER_TYPE_STUDENT){
        $user = Yii::$app->user->identity->getSchoolToUser($school_id,UserToSchool::SCHOOL_USER_TYPE_STUDENTS);
    }
    if($grade_user_type == UserToGrade::GRADE_USER_TYPE_TEACHER){
        $user = Yii::$app->user->identity->getSchoolToUser($school_id,UserToSchool::SCHOOL_USER_TYPE_TEACHER);
    }
    $currentUser =  [];
   foreach ($user as $key => $value) {
       if(!empty($value['realname'])){
            $currentUser[$value['id']] = $value['realname'];
            continue;
       }
       if(!empty($value['username'])){
            $currentUser[$value['id']] = $value['username'];
       }
   }
    //var_dump($currentUser);exit;
     //$currentUser = ArrayHelper::map($user,'id','username');

?>
<?php
    if(isset($info['error']) && !empty($info['error']) ){
        //dump($info);
         echo "<div class='error-summary alert alert-error'>";
         echo "<p>错误警告：</p>";
         echo "<ul>";
        foreach ($info['error'] as $key => $value) {
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
<div class="user-to-grade-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'UserToGrade',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>

        <!-- attribute user_id -->
            <?php
                if($model->isNewRecord){
                    echo $form->field($model, 'user_id')->widget(Select2::className(),[
                        // 'language'          => 'en',
                        // "showToggleAll"     => true,
                        'data'              => $currentUser,
                        'theme'             => Select2::THEME_BOOTSTRAP,
                        "maintainOrder"     => true,
                        'toggleAllSettings' => [
                            'selectLabel'   => '<i class="glyphicon glyphicon-unchecked"></i> 全选',
                            'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>取消全选'
                        ],
                        'options' => [
                            'placeholder' => '请选择',
                            'multiple'    => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
                }else{
                    //var_dump('<pre>',$currentUser);exit;
                    echo $form->field($model, 'user_id')->widget(Select2::className(),[
                        'data'     => $currentUser,
                        'disabled' => true,
                    ]);
                }

            ?>

        <!--  attribute school_id  -->
            <?= $form->field($model, 'school_id')->widget(Select2::className(),[
                'data' =>$currentSchool,
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [ 
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange(1,this.value,'#usertograde-grade_id');
                    }"
                ]
            ]) ?>

        <!-- attribute grade_id -->
            <?= $form->field($model, 'grade_id')->widget(Select2::className(),[
                'data' =>  $model->getlist(1,$model->school_id),
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

        <!-- attribute user_title_id_at_grade -->
        	<!-- <? /*$form->field($model, 'user_title_id_at_grade')->widget(Select2::className(),[
                'data'          => UserToGrade::optsUserTitleType(),
                'hideSearch'    => true,
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ])*/ ?> -->

        <!-- attribute status -->
            <?= $form->field($model,'status')->widget(Select2::className(),[
                'data'          =>$status,
                'hideSearch'    => true,
                // 'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ])->label('状态') ?>

        <!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput() ?>

            <?= $form->field($model,'grade_user_type')->hiddenInput(['value'=>$grade_user_type])->label(false)->hint(false)?>
            <?= $form->field($model,'user_title_id_at_grade')->hiddenInput(['value'=>$grade_user_type])->label(false)->hint(false)?>
        <!-- attribute grade_user_type -->
          <!--   <? /* $form->field($model,'grade_user_type')->widget(Select2::className(),[
                'data'          => UserToGrade::optsUserType(),
                'hideSearch'    => true,
                // 'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => false
                ],
            ])->label('类型') */?> -->


        </p>
        <?php $this->endBlock(); ?>
        
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '班级人员管理'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>
        <hr/>

        

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新')),
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
            "url":"<?php echo Url::to(['user-to-grade/ajax-form'])?>",
            "data":{type_id:type_id,id:id},
            'type':"GET",
            'success':function(data){
                 $(form).html(data);
            }
        }) 
    }
</script>

