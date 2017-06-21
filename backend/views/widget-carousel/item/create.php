<?php
/** @var $this yii\web\View
 * @var $model common\models\WidgetCarouselItem
 * @var $carousel common\models\WidgetCarousel
 */

$this->title = Yii::t('backend', '创建', [
    'modelClass' => 'Widget Carousel Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '轮播组件项目'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $carousel->key, 'url' => ['update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '创建');
?>
<div class="widget-carousel-item-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'carousel'=>$carousel
    ]) ?>

</div>
