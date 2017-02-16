<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\courseware\Courseware */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseware-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->courseware_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->courseware_id], [
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
            'courseware_id',
            'category_id',
            'level',
            'creater_id',
            'slug',
            'title',
            'body:ntext',
            'parent_id',
            'access_domain',
            'access_other',
            'status',
            'items',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
