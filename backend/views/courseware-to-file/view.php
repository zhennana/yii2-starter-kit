<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\courseware\CoursewareToFile */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseware-to-file-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->courseware_to_file_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->courseware_to_file_id], [
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
            'courseware_to_file_id',
            'school_id',
            'grade_id',
            'title',
            'status',
            'sort',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
