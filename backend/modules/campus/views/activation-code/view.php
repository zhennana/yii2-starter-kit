<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\ActivationCode */

$this->title = $model->activation_code_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Activation Codes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activation-code-view">

    <p>
        <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->activation_code_id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->activation_code_id], [
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
            'activation_code_id',
            'activation_code',
            'courseware_id',
            'course_order_item_id',
            'school_id',
            'grade_id',
            'user_id',
            'introducer_id',
            'payment',
            'status',
            'total_price',
            'real_price',
            'coupon_price',
            'coupon_type',
            'expired_at',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
