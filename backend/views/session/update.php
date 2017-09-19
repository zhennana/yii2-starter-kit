<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var common\models\Session $model
*/
    
$this->title = Yii::t('backend', 'Session') . " " . $model->id . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Session'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud session-update">

    <h1>
        <?= Yii::t('backend', 'Session') ?>
        <small>
                        <?= $model->id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '查看'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
