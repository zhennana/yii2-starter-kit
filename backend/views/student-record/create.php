<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\school\StudentRecord */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Student Record',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Student Records'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-record-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
