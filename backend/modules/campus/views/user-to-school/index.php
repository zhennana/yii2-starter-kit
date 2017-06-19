<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\campus\models\UserToSchool;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\campus\models\search\UserToSchoolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'User To Schools');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-school-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '导入新人员'), ['user-to-school-form'], ['class' => 'btn btn-success']) 
    ?>
  
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
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'school_user_type',
                'options'   => ['width' => '10%'],
                'format'    => 'raw',
                'enum'      => UserToSchool::optsUserType(),
            ],
            [
                'class'     =>\common\grid\EnumColumn::className(),
                'attribute' =>'status',
                'options'   => ['width' => '10%'],
                'format'    => 'raw',
                'enum'      => UserToSchool::optsUserStatus(),
            ],
            'updated_at:datetime',
            'created_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
