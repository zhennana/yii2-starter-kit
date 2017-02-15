<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\school\StudentRecordItem $model
*/

$this->title = Yii::t('backend', 'StudentRecordItem') . $model->student_record_item_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'StudentRecordItems'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->student_record_item_id, 'url' => ['view', 'student_record_item_id' => $model->student_record_item_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud student-record-item-update">

    <h1>
        <?= Yii::t('backend', 'StudentRecordItem') ?>
        <small>
                        <?= $model->student_record_item_id ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('backend', 'View'), ['view', 'student_record_item_id' => $model->student_record_item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
