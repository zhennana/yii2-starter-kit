<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\SignIn $model
*/
    
$this->title = Yii::t('models', 'Sign In') . " " . $model->signin_id . ', ' . 'Edit';
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Sign In'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->signin_id, 'url' => ['view', 'signin_id' => $model->signin_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="giiant-crud sign-in-update">

    <h1>
        <?= Yii::t('models', 'Sign In') ?>
        <small>
                        <?= $model->signin_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . 'View', ['view', 'signin_id' => $model->signin_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
