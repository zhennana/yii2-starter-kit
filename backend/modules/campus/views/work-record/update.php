<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\WorkRecord $model
*/
    
$this->title = Yii::t('models', '教师工作记录') . " " . $model->title . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '教师工作记录'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'work_record_id' => $model->work_record_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '修改');
?>
<div class="giiant-crud work-record-update">

    <h1>
        <?= Yii::t('models', '教师工作记录') ?>
        <small>
                        <?= $model->title ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'work_record_id' => $model->work_record_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
