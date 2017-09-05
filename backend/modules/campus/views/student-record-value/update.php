<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecordValue $model
*/
    
$this->title = Yii::t('backend', '成绩管理') . " " . $model->student_record_value_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '成绩管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->student_record_value_id, 'url' => ['view', 'student_record_value_id' => $model->student_record_value_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud student-record-value-update">

    <h1>
        <?= Yii::t('backend', '成绩管理') ?>
        <small>
                        <?= $model->student_record_value_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '查看'), ['view', 'student_record_value_id' => $model->student_record_value_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
