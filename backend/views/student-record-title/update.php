<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecordTitle */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Student Record Title',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->student_record_title_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="student-record-title-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
