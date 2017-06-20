<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
*/
    
$this->title = Yii::t('models', '课程订单') . " " . $model->course_order_item_id . ', ' . Yii::t('cruds', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '课程订单'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->course_order_item_id, 'url' => ['view', 'course_order_item_id' => $model->course_order_item_id]];
$this->params['breadcrumbs'][] = Yii::t('cruds', '更新');
?>
<div class="giiant-crud course-order-item-update">

    <h1>
        <?= Yii::t('models', '课程订单') ?>
        <small>
            <?= $model->course_order_item_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('cruds', '查看'), ['view', 'course_order_item_id' => $model->course_order_item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
        'schools'=>$schools
    ]); ?>

</div>
