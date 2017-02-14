<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\grade\Grade */

$this->title = Yii::t('backend', 'Create Grade');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grades'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
