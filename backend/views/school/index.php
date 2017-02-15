<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\SchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Schools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'School',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'school_id',
            'language',
            'school_title',
            // 'school_short_title',
            // 'school_slogan',
            // 'school_logo_path',
            // 'school_backgroud_path',
            // 'longitude',
            // 'latitude',
            // 'address',
            // 'province_id',
            // 'city_id',
            // 'region_id',
            // 'created_at',
            // 'updated_at',
            // 'created_id',
            // 'status',
            // 'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
