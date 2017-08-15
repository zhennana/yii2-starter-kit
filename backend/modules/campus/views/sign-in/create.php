<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
*/

$this->title = Yii::t('models', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '签到管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud sign-in-create">

    <h1>
        <?= Yii::t('models', '签到管理') ?>
        <small>
            <?= $model->signin_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?= Html::a(
                Yii::t('models', '取消'),
                \yii\helpers\Url::previous(),
                ['class' => 'btn btn-default']
            ) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
        'model' => $model,
        'data'  => isset($data) ? $data : NULL,
        'grades'=>$grades,
        'schools'   => $schools,
    ]); ?>

</div>
