<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecordItem */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Student Record Item',
]) . ' ' . $model->student_record_item_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->student_record_item_id, 'url' => ['view', 'id' => $model->student_record_item_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="student-record-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
