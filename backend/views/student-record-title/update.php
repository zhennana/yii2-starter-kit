<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\school\StudentRecordTitle $model
*/

$this->title = Yii::t('backend', 'StudentRecordTitle') . $model->title . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'StudentRecordTitles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_title_id' => $model->student_record_title_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud student-record-title-update">

    <h1>
        <?= Yii::t('backend', 'StudentRecordTitle') ?>
        <small>
                        <?= $model->title ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('backend', 'View'), ['view', 'student_record_title_id' => $model->student_record_title_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
