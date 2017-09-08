<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use yii\helpers\StringHelper;
use kartik\select2\Select2;
use backend\modules\campus\models\StudentRecordValue;
use backend\modules\campus\models\StudentRecordKey;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
* @var yii\widgets\ActiveForm $form
*/
$keys = StudentRecordKey::find()->where(['status'=>StudentRecordKey::STUDENT_KEY_STATUS_OPEN])->all();
$keys = ArrayHelper::map($keys,'student_record_key_id','title');

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

<div class="student-record-value-form">

    <?php $form = ActiveForm::begin([
    'id' => 'StudentRecordValue',
    'layout' => 'horizontal',
    'enableClientValidation' => true,
    'errorSummaryCssClass' => 'error-summary alert alert-error'
    ]
    );
    ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>

        <p>
            
<!-- attribute student_record_key_id -->
            <?= $form->field($model, 'student_record_key_id')->widget(Select2::className(), [
                'data'=>$keys,
                // 'hideSearch' => true,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'school_id')->widget(Select2::className(),[
                'data' => $schools,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange('school_id',this.value,'#studentrecordvalue-grade_id');
                    }"
                ]
            ]) ?>

            <?= $form->field($model, 'grade_id')->widget(Select2::className(),[
                'data' => $grades,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange('grade_id',this.value,'#studentrecordvalue-user_id');
                    }"
                ]
            ]) ?>

            <?= $form->field($model, 'user_id')->widget(Select2::className(),[
                'data' => $data_user,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

<!-- attribute student_record_id -->
            <!--<?php /* echo $form->field($model, 'student_record_id')->textInput() */ ?>-->

            <?= $form->field($model, 'exam_type')->widget(Select2::className(), [
                'data'=>StudentRecordValue::optsExamType(),
                'hideSearch' => true,
                'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'total_score')->textInput() ?>

            <?= $form->field($model, 'score')->textInput() ?>

<!-- attribute body -->
            <!--<?php /* echo $form->field($model, 'body')->textInput(['maxlength' => true]) */ ?>-->

<!-- attribute status -->
            <?= $form->field($model, 'status')->widget(Select2::className(), [
                'data'=>StudentRecordValue::optsStatus(),
                'hideSearch' => true,
                // 'options'       => ['placeholder' => Yii::t('backend','请选择')],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label('状态'); ?>

<!-- attribute sort -->
            <?= $form->field($model, 'sort')->textInput() ?>
        </p>
        <?php $this->endBlock(); ?>
        
        <?=
    Tabs::widget(
                 [
                    'encodeLabels' => false,
                    'items' => [ 
                        [
    'label'   => Yii::t('backend', '成绩管理'),
    'content' => $this->blocks['main'],
    'active'  => true,
],
                    ]
                 ]
    );
    ?>
        <hr/>

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

        <?php ActiveForm::end(); ?>

    </div>

</div>

<script type="text/javascript">
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
</script>