<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
*/
    
$this->title = Yii::t('models', 'Course') . " " . $model->title . ', ' . Yii::t('common', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Course'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'course_id' => $model->course_id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Edit');
?>
<div class="giiant-crud course-update">

    <h1>
        <?= Yii::t('models', 'Course') ?>
        <small>
                        <?= $model->title ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('common', 'View'), ['view', 'course_id' => $model->course_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
