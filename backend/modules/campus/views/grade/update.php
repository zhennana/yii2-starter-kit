<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Grade $model
*/
    
$this->title = Yii::t('backend', 'Grade') . " " . $model->grade_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Grade'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->grade_id, 'url' => ['view', 'grade_id' => $model->grade_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud grade-update">

    <h1>
        <?= Yii::t('backend', 'Grade') ?>
        <small>
                        <?= $model->grade_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'grade_id' => $model->grade_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
