<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UserToSchool */

$this->title = $model->user_to_school_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User To Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-school-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->user_to_school_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->user_to_school_id], [
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
            'user_to_school_id',
            'user_id',
            'school_id',
            'user_title_id_at_school',
            'status',
            'sort',
            'school_user_type',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
