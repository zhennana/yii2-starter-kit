<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\school\School */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'School',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="school-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
