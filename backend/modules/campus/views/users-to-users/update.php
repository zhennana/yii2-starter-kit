<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UsersToUsers */

// $this->title = Yii::t('backend', 'Update {modelClass}: ', [
//     'modelClass' => 'Users To Users',
// ]) . ' ' . $model->users_to_users_id;
// $this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Users To Users'), 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->users_to_users_id, 'url' => ['view', 'id' => $model->users_to_users_id]];
// $this->params['breadcrumbs'][] = Yii::t('backend', 'Update');


$this->title = Yii::t('backend', '修改账号关系') . " " . $model->users_to_users_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '账号关系管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->users_to_users_id, 'url' => ['view', 'users_to_users_id' => $model->users_to_users_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="users-to-users-update">
    <h1>
        <?= Yii::t('backend', '账号关系管理') ?>
        <small>
            <?= $model->users_to_users_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'users_to_users_id' => $model->users_to_users_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
