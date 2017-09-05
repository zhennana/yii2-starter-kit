<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
*/

$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = ['label' => (env('THEME') == 'gedu') ? Yii::t('backend', '创建成绩') : Yii::t('backend', '创建学生档案'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud student-record-value-create">

    <h1>
        <?= (env('THEME') == 'gedu') ? Yii::t('backend', '创建成绩') : Yii::t('backend', '创建学生档案') ?>
        <small>
                      <!--   <? //= $model->student_record_value_id ?> -->
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('backend', '取消'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    'info'  => isset($info) ? $info : NULL
    ]); ?>

</div>
