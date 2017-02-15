<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\courseware\CoursewareToFile */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Courseware To File',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Courseware To Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseware-to-file-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
