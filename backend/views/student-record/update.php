<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\school\StudentRecord $model
*/

$this->title = Yii::t('backend', 'StudentRecord') . $model->title . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'StudentRecords'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_id' => $model->student_record_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud student-record-update">

    <h1>
        <?= Yii::t('backend', 'StudentRecord') ?>
        <small>
                        <?= $model->title ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('backend', 'View'), ['view', 'student_record_id' => $model->student_record_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
