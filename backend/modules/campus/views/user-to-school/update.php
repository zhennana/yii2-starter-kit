<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UserToSchool */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'User To School',
]) . ' ' . $model->user_to_school_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User To Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_to_school_id, 'url' => ['view', 'id' => $model->user_to_school_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="user-to-school-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
