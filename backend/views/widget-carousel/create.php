<?php
/* @var $this yii\web\View */
/* @var $model common\models\WidgetCarousel */

$this->title = Yii::t('backend', '创建', [
    'modelClass' => 'Widget Carousel',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '轮播组件'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
