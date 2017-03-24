<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
*/
    
$this->title = Yii::t('models', '签到管理') . " " . $model->signin_id . ', ' . Yii::t('models', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', '签到管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->signin_id, 'url' => ['view', 'signin_id' => $model->signin_id]];
$this->params['breadcrumbs'][] = Yii::t('models', '更新');
?>

<div class="giiant-crud sign-in-update">

    <h1>
        <?= Yii::t('models', '签到管理') ?>
        <small>
            <?= $model->signin_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a(
            '<span class="glyphicon glyphicon-file"></span> ' . Yii::t('models', '查看'),
            ['view', 'signin_id' => $model->signin_id],
            ['class' => 'btn btn-default']
        ) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
