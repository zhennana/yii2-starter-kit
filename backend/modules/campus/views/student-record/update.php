<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\StudentRecord $model
*/
    
$this->title = Yii::t('backend', '学员档案管理') . " " . $model->title . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学员档案管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->title, 'url' => ['view', 'student_record_id' => $model->student_record_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud student-record-update">

    <h1>
        <?= Yii::t('backend', '学员档案管理') ?>
        <small>
                        <?= $model->title ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '查看'), ['view', 'student_record_id' => $model->student_record_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
