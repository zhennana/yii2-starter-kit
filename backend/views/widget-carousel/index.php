<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\WidgetCarouselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '轮播组件');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-carousel-index">

    <p>
        <?php 
        $string = '{update}';
            if(Yii::$app->user->can('manager')){
                echo Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建', [
                        'modelClass' => 'Widget Carousel',
                    ]), ['create'], ['class' => 'btn btn-success']);
                $string = "{update}{delete}";
            }
        ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'key',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'status',
                'enum'=>[
                    Yii::t('backend', '无效'),
                    Yii::t('backend', '有效')
                ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>$string
            ],
        ],
    ]); ?>

</div>
