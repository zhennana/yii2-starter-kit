<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
*/
    
$this->title = Yii::t('backend', 'User To Grade') . " " . $model->user_to_grade_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User To Grade'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->user_to_grade_id, 'url' => ['view', 'user_to_grade_id' => $model->user_to_grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud user-to-grade-update">

    <h1>
        <?= Yii::t('backend', 'User To Grade') ?>
        <small>
                        <?= $model->user_to_grade_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'user_to_grade_id' => $model->user_to_grade_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
