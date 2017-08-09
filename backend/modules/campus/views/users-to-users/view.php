<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\modules\campus\models\UsersToUsers;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UsersToUsers */

$this->title = Yii::t('backend', '账号关系详情');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '账号关系详情'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->users_to_users_id, 'url' => ['view', 'users_to_users_id' => $model->users_to_users_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '账号关系详情');
$copyParams = $model->attributes;
?>
<div class="users-to-users-view">
    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= Yii::t('backend', '账号关系详情') ?>
        <small>
            <?= $model->users_to_users_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <?php if(Yii::$app->user->can('manager') || \Yii::$app->user->can('E_manager')){
        ?>
            <div class='pull-left'>
                <?= Html::a(
                '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '修改'),
                [ 'update', 'users_to_users_id' => $model->users_to_users_id],
                ['class' => 'btn btn-info']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('backend', '克隆'),
                ['create', 'users_to_users_id' => $model->users_to_users_id, 'Courseware'=>$copyParams],
                ['class' => 'btn btn-success']) ?>

                <?= Html::a(
                '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('backend', '创建'),
                ['create'],
                ['class' => 'btn btn-success']) ?>
            </div>
        <?php  } ?>
        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <br />
    <hr>
    <br />


    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'users_to_users_id',
            [
                'attribute' => 'user_left_id',
                'value' => function($model){
                    return $model->user_left_id.' - '.UsersToUsers::getUserName($model->user_left_id);
                }
            ],
            [
                'attribute' => 'user_right_id',
                'value' => function($model){
                    return $model->user_right_id.' - '.UsersToUsers::getUserName($model->user_right_id);
                }
            ],
            [
                'attribute' => 'type',
                'value'     => UsersToUsers::getTypeLabel($model->type)
            ],
            [
                'attribute' => 'status',
                'value'     => UsersToUsers::getStatusLabel($model->status)
            ],
        ],
    ]) ?>

</div>
