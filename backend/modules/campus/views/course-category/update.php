<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\CourseCategory */

$this->title = Yii::t('backend', '修改课程分类') . " " . $model->name . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'category_id' => $model->category_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="course-category-update">
    <h1>
        <?= Yii::t('backend', '课程分类') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'category_id' => $model->category_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
