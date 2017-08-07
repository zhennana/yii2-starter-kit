<?php


use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use kartik\select2\Select2;
use backend\modules\campus\models\Notice;
use backend\modules\campus\models\UserToGrade;
use common\models\User;
//var_dump($model->getList(1));exit;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Notice $model
* @var yii\widgets\ActiveForm $form
*/
//var_dump($category);exit;
if($category == 1){
    $handleChange  = "function() {
                            handleChange(2,this.value,'#notice-receiver_id');
                    }";
}else{
    $handleChange  = "function() {
                            handleChange(1,this.value,'#notice-grade_id');
                    }";
}
?>

<div class="notice-form">

    <?php $form = ActiveForm::begin([
        'id'                     => 'Notice',
        'layout'                 => 'horizontal',
        'enableClientValidation' => true,
        'errorSummaryCssClass'   => 'error-summary alert alert-error'
    ]); ?>

    <div class="">
        <?php $this->beginBlock('main'); ?>
        <?php
            if(!isset($info)){
                echo $form->errorSummary($model);
            }else{
                echo $form->errorSummary($info);
            }
        ?>
        <p>
<!-- attribute category -->
            <?= $form->field($model, 'category')->textInput()->hiddenInput([
                'value' => $category
                ])->label(false)->hint(false) ?>

<!-- attribute title -->
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<!-- attribute message -->
            <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

            <?=
                $form->field($model, 'school_id')->widget(Select2::className(),[
                // 'language'          => 'en',
                // 'showToggleAll'     => true,
                'data'              => $schools,
                'theme'             => Select2::THEME_BOOTSTRAP,
                "maintainOrder"     => true,
                'options' => [
                    'placeholder' => '请选择',
                    'multiple'    => false,
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                        "change" =>$handleChange,
                ]
            ]);
            ?>
            <?php if($category == 2){?>
            <?=
                $form->field($model, 'grade_id')->widget(Select2::className(),[
                // 'language'          => 'en',
                // 'showToggleAll'     => true,
                'data'              => [],
                'theme'             => Select2::THEME_BOOTSTRAP,
                "maintainOrder"     => true,
                'toggleAllSettings' => [
                    'selectLabel'   => '<i class="glyphicon glyphicon-unchecked"></i> 全选',
                    'unselectLabel' => '<i class="glyphicon glyphicon-check"></i>取消全选'
                ],
                'options' => [
                    'placeholder' => '请选择',
                    'multiple'    => false,
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
                'pluginEvents' => [
                    "change" => "function() {
                        handleChange(2,this.value,'#notice-receiver_id');
                    }",
                ]
            ]);
            ?>
            <?php } ?>
            <?=
              $form->field($model, 'receiver_id')->widget(Select2::className(),[
                // 'language'          => 'en',
                // 'showToggleAll'     => true,
                'data'              => [],
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
            ?>
<!-- attribute status_send -->
            <!-- <? // $form->field($model, 'status_send')->dropDownList($model->optsStatusSend()) ?> -->
            <?php
                if($category == 1){
            ?>
            <?= $form->field($model,'is_a_push')->checkbox()->label('是否个推')?>
            <?php }?>
        </p>
        <?php $this->endBlock(); ?>
        <?= Tabs::widget([
            'encodeLabels' => false,
            'items'        => [[
                'label'   => Yii::t('backend', '消息管理'),
                'content' => $this->blocks['main'],
                'active'  => true,
            ]]
        ]); ?>

        <hr/>
        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-check"></span> ' .
            ($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Save')),
            [
                'id'    => 'save-' . $model->formName(),
                'class' => 'btn btn-success'
            ]
        );
        ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<script type="text/javascript">
    function handleChange(type_id,id,form){
        var category = "<?php echo $category ?>";
        $.ajax({
            "url":"<?php echo Url::to(['ajax-form'])?>",
            "data":{type_id:type_id,id:id,category:category},
            'type':"GET",
            'success':function(data){
                $('#course-teacher_id option').remove();
                $(form).html(data);
            }
        })
    }
</script>