<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecordTitle */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Student Record Title',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Record Titles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-record-title-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
