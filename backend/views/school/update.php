<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\school\School */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'School',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="school-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
