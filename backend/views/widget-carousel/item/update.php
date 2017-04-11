<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarouselItem */

$this->title = Yii::t('backend', '更新 ', [
    'modelClass' => 'Widget Carousel Item',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '轮播组件项目'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->carousel->key, 'url' => ['update', 'id' => $model->carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="widget-carousel-item-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
