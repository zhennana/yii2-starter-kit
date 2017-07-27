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
    <br/>
    <p>
    <?php
        $e_roles = Yii::$app->authManager->getChildRoles('E_administrator');
        $p_roles = Yii::$app->authManager->getChildRoles('P_administrator');
        $role = ArrayHelper::merge($e_roles,$p_roles);
        $auth = ArrayHelper::map($role, 'name', 'description');
        foreach ($auth as $key => $value) {
            echo ' '.Html::a(
                Yii::t('backend', $value, ['modelClass' => 'User']), 
                ['index','UserSearch[item_name]'=>$key], 
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
            'realname',
            'phone_number',
            [
                'class' => EnumColumn::className(),
                'attribute' => 'status',
                'enum' => User::statuses(),
                'filter' => User::statuses()
            ],
            'username',
            'email:email',
            'created_at:datetime',
            'logged_at:datetime',
            // 'updated_at',

            [
            'class' => 'yii\grid\ActionColumn',
             'template' => "{update}{view}",
            ],
        ],
    ]); ?>

</div>
