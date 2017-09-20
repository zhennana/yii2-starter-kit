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

    <?php echo $form->errorSummary($newModel); ?>

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

 
            <?= $form->field($model,'user_id')->textInput(['disabled'=>'disabled','value'=>Yii::$app->user->identity->getUserName($model->user_id)])->label()?>
            <?= $form->field($model,'school_id')->textInput(['disabled'=>'disabled','value'=>isset($model->school->school_title)? $model->school->school_title : $model->school_id])->label()?>
            <?= $form->field($model,'[0]grade_id',[])->textInput(['disabled'=>'disabled','value'=>isset($model->grade->grade_name)? $model->grade->grade_name : $model->grade_id])->label()?>
        <!-- attribute grade_id -->
            <?= $form->field($newModel, 'grade_id')->widget(Select2::className(),[
                'data' =>  $newModel->getlist(1,$model->school_id),
                'options'       => ['placeholder' => '请选择'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ])->label('目标班级')->hint('') ?>


        </p>
        <?php $this->endBlock(); ?>

        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '转班'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>
        <hr/>

        

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('common','转班'),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

