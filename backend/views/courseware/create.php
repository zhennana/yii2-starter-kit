<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\courseware\Courseware */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'Courseware',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Coursewares'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="courseware-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
