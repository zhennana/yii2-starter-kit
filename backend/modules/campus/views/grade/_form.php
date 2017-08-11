<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\GradeCategory;
use common\models\User;

    /**
    * @var yii\web\View $this
    * @var backend\modules\campus\models\Grade $model
    * @var yii\widgets\ActiveForm $form
    */

    $schools = [Yii::$app->user->identity->currentSchool];
    $schools = ArrayHelper::map($schools,'school_id','school_title');

    $category_ids = GradeCategory::find()->where(['status'=>GradeCategory::CATEGORY_OPEN])->asArray()->all();
    $category_ids = ArrayHelper::map($category_ids,'grade_category_id','name');

    $user = Yii::$app->user->identity->getSchoolToUser(Yii::$app->user->identity->currentSchoolId , 20);
    //var_dump('<pre>',$user);exit;
    // getSchoolToUser
    $data_user =  [];
   foreach ($user as $key => $value) {
       if(!empty($value['realname'])){
            $data_user[$value['id']] = $value['realname'];
            continue;
       }
       if(!empty($value['username'])){
            $data_user[$value['id']] = $value['username'];
       }
   }
   //var_dump($data_user);exit;
?>

<div class="grade-form">

    <?php $form = ActiveForm::begin([
        'id' => 'Grade',
        'layout' => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]);
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            <?php 
                $model->school_id =Yii::$app->user->identity->currentSchoolId
            ?>
<!-- attribute school_id -->
			<?= $form->field($model, 'school_id')->dropDownlist($schools,['prompt'=>'--请选择--']) ?>

            <?= $form->field($model,'group_category_id')->dropDownlist($category_ids,['prompt'=>'--请选择--']) ?>
<!-- attribute grade_name -->
            <?= $form->field($model, 'grade_name')->textInput(['maxlength' => true]) ?>

<!-- attribute grade_title -->
		<!-- 	<? // $form->field($model, 'grade_title')->textInput() ?> -->

<!-- attribute owner_id -->
            <?= $form->field($model, 'owner_id')->dropDownlist($data_user,['prompt'=>'--请选择--']) ?>

<!-- attribute creater_id -->
			<!-- <? //= $form->field($model, 'creater_id')->textInput() ?> -->

<!-- attribute time_of_graduation -->
			<!-- <? // = // $form->field($model, 'time_of_graduation')->textInput() ?> -->

<!-- attribute time_of_enrollment -->
			<!-- <? // = $form->field($model, 'time_of_enrollment')->textInput() ?> -->


<!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput() ?>

<!-- attribute status -->
            <?= $form->field($model, 'status')->dropDownlist(Grade::optsStatus()) ?>
<!-- attribute graduate -->
           <!--  <? // = //$form->field($model, 'graduate')->dropDownlist(Grade::optsGraduate()) ?> -->
        </p>
        <?php $this->endBlock(); ?>
        
    <?=
        Tabs::widget([
            'encodeLabels' => false,
            'items' => [                   
                [
                    'label'   => Yii::t('backend', '班级管理'),
                    'content' => $this->blocks['main'],
                    'active'  => true,
                ],
            ]
        ]);
    ?>
        <hr/>

        <?php echo $form->errorSummary($model); ?>

        <?= Html::submitButton(
        '<span class="glyphicon glyphicon-check"></span> ' .
        ($model->isNewRecord ? Yii::t('backend', '创建') : Yii::t('backend', '更新')),
        [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
        ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>

