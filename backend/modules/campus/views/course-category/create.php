<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\CourseCategory */

$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-category-create">
    <h1>
        <?= Yii::t('backend', '课程分类') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('backend', '返回'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />
    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
