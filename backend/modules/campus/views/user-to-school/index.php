<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\UserToSchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User To Schools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-school-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a(Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'User To School',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_to_school_id',
            'user_id',
             [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'school_id',
                'options'   => ['width' => '10%'],
                'format'    => 'raw',
                'enum'      => $schools,
            ],
           // 'school_id',
            'user_title_id_at_school',
            'status',
            // 'sort',
            'school_user_type',
            // 'updated_at',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
