<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseSchedule $model
*/
    
$this->title = Yii::t('models', '排课修改') . " " . $model->course_schedule_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Course Schedule'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->course_schedule_id, 'url' => ['view', 'course_schedule_id' => $model->course_schedule_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud course-schedule-update">

    <h1>
        <?= Yii::t('models', '排课修改') ?>
        <small>
                        <?= $model->course_schedule_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'course_schedule_id' => $model->course_schedule_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
