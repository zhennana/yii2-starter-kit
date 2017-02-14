<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\grade\GradeProfile */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Grade Profile',
]) . $model->grade_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grade Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->grade_id, 'url' => ['view', 'id' => $model->grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="grade-profile-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
