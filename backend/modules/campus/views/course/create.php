<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Course $model
*/

$this->title = Yii::t('backend', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '课程管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud course-create">

    <h1>
        <?= Yii::t('backend', '课程管理') ?>
        <small>
            <?= $model->title ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(Yii::t('backend', '取消'),
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default'])
            ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
        'model' => $model,
        'schools'=>$schools
    ]); ?>

</div>
