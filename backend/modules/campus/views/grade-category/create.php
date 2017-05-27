<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\GradeCategroy $model
*/

$this->title = Yii::t('backend', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '班级分类管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud grade-categroy-create">

    <h1>
        <?= Yii::t('models', '班级分类管理') ?>
        <small>
            <?= $model->name ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('backend', '取消'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    'parent_category' => $parent_category,
    ]); ?>

</div>
