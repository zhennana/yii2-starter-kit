<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\grade\GradeProfile */

$this->title = Yii::t('backend', 'Create Grade Profile');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grade Profiles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grade-profile-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
