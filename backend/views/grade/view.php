<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\grade\Grade */

$this->title = $model->grade_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->grade_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->grade_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'grade_id',
            'school_id',
            'classroom_group_levels',
            'grade_name',
            'grade_title',
            'owner_id',
            'creater_id',
            'updated_at',
            'created_at',
            'sort',
            'status',
            'graduate',
            'time_of_graduation:datetime',
            'time_of_enrollment:datetime',
        ],
    ]) ?>

</div>
