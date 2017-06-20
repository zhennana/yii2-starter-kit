<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\CourseOrderItem $model
*/

$this->title = Yii::t('cruds', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '课程订单'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud course-order-item-create">

    <h1>
        <?= Yii::t('models', '课程订单') ?>
        <small>
            <?= $model->course_order_item_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(Yii::t('cruds', '取消'),
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
        'model' => $model,
        'schools'=>$schools
    ]); ?>

</div>
