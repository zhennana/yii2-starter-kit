<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\campus\models\ActivationCode;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\ActivationCode */

$this->title = $model->activation_code_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '激活码'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$copyParams = $model->attributes;
?>
<div class="activation-code-view">

    <p><?php
           if (\Yii::$app->user->can('E_manager') ||
                \Yii::$app->user->can('manager')
                ) {
        ?>
        <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
                [ 'update', 'activation_code_id' => $model->activation_code_id],
                ['class' => 'btn btn-info']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '克隆'),
                ['create', 'activation_code_id' => $model->activation_code_id, 'Courseware'=>$copyParams],
                ['class' => 'btn btn-success']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
                ['create'],
                ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'activation_code_id',
            'activation_code',
            [
                'attribute' => 'course_order_item_id',
                'value'     => function($model){
                    return isset($model->course_order_item_id) ? $model->course_order_item_id : '未使用';
                }
            ],
            [
                'attribute' => 'school_id',
                'value'     => function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                }
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model){
                    if ($model->user_id) {
                        return Yii::$app->user->identity->getUserName($model->user_id);
                    }
                }
            ],
            [
                'attribute' => 'introducer_id',
                'value' => function($model){
                    if ($model->introducer_id) {
                        return Yii::$app->user->identity->getUserName($model->introducer_id);
                    }
                }
            ],
            [
                'attribute' => 'payment',
                'value' => ActivationCode::getPaymentValueLabel($model->payment),
            ],
            [
                'attribute' => 'status',
                'value' => ActivationCode::getStatusValueLabel($model->status),
            ],
            'total_price',
            'real_price',
            'coupon_price',
            [
                'attribute' => 'coupon_type',
                'value' => ActivationCode::getCouponValueLabel($model->coupon_type),
            ],
            'expired_at:datetime',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
