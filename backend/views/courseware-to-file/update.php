<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\courseware\CoursewareToFile */

$this->title = Yii::t('backend', 'Update {modelClass}: ', [
    'modelClass' => 'Courseware To File',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->courseware_to_file_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="courseware-to-file-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
