<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\ActivationCodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Activation Codes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activation-code-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Activation Code',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'activation_code_id',
            'activation_code',
            'courseware_id',
            'course_order_item_id',
            'school_id',
            // 'grade_id',
            // 'user_id',
            // 'introducer_id',
            // 'payment',
            // 'status',
            // 'total_price',
            // 'real_price',
            // 'coupon_price',
            // 'coupon_type',
            // 'expired_at',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
