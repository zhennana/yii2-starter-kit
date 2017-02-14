<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\grade\Grade */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Grade',
]) . $model->grade_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->grade_id, 'url' => ['view', 'id' => $model->grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="grade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
