<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecordItem */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Student Record Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-record-item-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
