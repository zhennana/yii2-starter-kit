<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecordItem */

$this->title = $model->student_record_item_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-record-item-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->student_record_item_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->student_record_item_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'student_record_item_id',
            'student_record_title_id',
            'student_record_id',
            'body',
            'status',
            'sort',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
