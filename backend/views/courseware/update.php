<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\courseware\Courseware */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Courseware',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->courseware_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="courseware-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
