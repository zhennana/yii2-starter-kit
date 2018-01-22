<?php

use common\grid\EnumColumn;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', '用户');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建', [
    'modelClass' => 'User',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
    <?php
        $auth = ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
        foreach ($auth as $key => $value) {
            echo ' '.Html::a(
                Yii::t('backend', $value, ['modelClass' => 'User']), 
                ['index','UserSearch[role]'=>$key], 
                ['class' => 'btn btn-info']
            );
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
            'id',
            'username',
            'email:email',
            'phone_number',
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => User::statuses(),
                'filter' => User::statuses()
            ],
            'created_at:datetime',
            'logged_at:datetime',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
