<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\WidgetMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '页脚菜单');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-menu-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [
            'class' => 'grid-view table-responsive'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'key',
            'title',
            [
                'class'=>\common\grid\EnumColumn::className(),
                'attribute'=>'status',
                'enum'=>[
                    Yii::t('backend', 'Disabled'),
                    Yii::t('backend', 'Enabled')
                ],
            ],

            [
            'class' => 'yii\grid\ActionColumn', 
            'template'=>'{update}',
            'buttons'=>[
                'update'=>function($url, $model, $key){
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['footer-update','id'=>$model->id]);
                }
            ]
            ],
        ],
    ]); ?>

</div>
