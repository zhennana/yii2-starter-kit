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
use backend\modules\campus\models\GradeCategory;
use backend\modules\campus\models\UserToGrade;
use backend\modules\campus\models\UserToSchool;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
* @var yii\widgets\ActiveForm $form
*/
$schools = [Yii::$app->user->identity->currentSchool];
$schools = ArrayHelper::map($schools,'school_id','school_title');

$category_ids = GradeCategory::find()->where(['status'=>GradeCategory::CATEGORY_OPEN])->asArray()->all();
$category_ids = ArrayHelper::map($category_ids,'grade_category_id','name');

// 获取全校老师
$teacher = Yii::$app->user->identity->getSchoolToUser(Yii::$app->user->identity->currentSchoolId , UserToGrade::GRADE_USER_TYPE_TEACHER);
$data_teacher =  [];
foreach ($teacher as $key => $value) {
   if(!empty($value['realname'])){
        $data_teacher[$value['id']] = $value['realname'];
        continue;
   }
   if(!empty($value['username'])){
        $data_teacher[$value['id']] = $value['username'];
   }
}

// 获取原班级学生
$students = Yii::$app->user->identity->getGradeToUser($grade_id , UserToGrade::GRADE_USER_TYPE_STUDENT);
$data_student =  [];
foreach ($students as $key => $value) {
   if(!empty($value['realname'])){
        $data_student[$value['id']] = $value['realname'];
        continue;
   }
   if(!empty($value['username'])){
        $data_student[$value['id']] = $value['username'];
   }
}

?>
<?php
    if(isset($info['error']) && !empty($info['error']) ){
        // dump($info);
        echo "<div class='error-summary alert alert-error'><p>错误警告：</p><ul>";
        foreach ($info['error'] as $key => $value) {
            if(isset($value) && is_array($value)){
                foreach ($value as $k => $v) {
                    if(is_string($v)){
                        echo "<li style='padding:0 3px'>".$v."</li>";
                    }
                    if(is_array($v)){
                        foreach ($v as  $v1) {
                            if(is_string($v1)){
                                echo "<li style='padding:0 3px'>用户ID".$key.'：'.$v1."</li>";
                            }
                        }
                    }
                }
            }
        }
        echo "</ul></div>";
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
        <?php 
            // 默认值
            $model->school_id = Yii::$app->user->identity->currentSchoolId;
            $model->status    = Grade::GRADE_STATUS_OPEN;
        ?>
<!-- attribute school_id -->
            <?= $form->field($model, 'school_id')->widget(Select2::ClassName(),[
                    'data'          => $schools,
                    'hideSearch'    => true,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ]
            ]) ?>

<!-- attribute group_category_id -->
            <?= $form->field($model, 'group_category_id')->widget(Select2::ClassName(),[
                    'data'          => $category_ids,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ]
            ]) ?>

<!-- attribute grade_name -->
            <?= $form->field($model, 'grade_name')->textInput(['maxlength' => true]) ?>

<!-- attribute owner_id -->
            <?= $form->field($model, 'owner_id')->widget(Select2::ClassName(),[
                    'data'          => $data_teacher,
                    'options'       => ['placeholder' => '请选择'],
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ]
            ])->hint('请选择新班级的班主任') ?>

<!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput() ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->widget(Select2::ClassName(),[
                    'data'          => Grade::optsStatus(),
                    'options'       => ['placeholder' => '请选择'],
                    'hideSearch'    => true,
                    'pluginOptions' => [
                        'allowClear'=> true,
                    ]
            ]) ?>

<!-- UserToGrade attribute user_id -->
            <?= $form->field($userToGradeModel, 'user_id')->widget(Select2::className(),[
                'data'              => $data_student,
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
            ])->hint('请选择升级至新班级的学生'); ?>

        </p>
        <?php $this->endBlock(); ?>

        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '升班'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ],]
        ]); ?>
        <hr/>

        
        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            Yii::t('common','升班'),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success',
                'data' => ['confirm' => '你确定要升班吗？该操作将不可撤销。',] 
            ]
        ); ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

