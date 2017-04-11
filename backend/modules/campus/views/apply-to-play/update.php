<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ApplyToPlay $model
*/
    
$this->title = Yii::t('backend', '预约信息') . " " . $model->apply_to_play_id . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '预约信息'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->apply_to_play_id, 'url' => ['view', 'apply_to_play_id' => $model->apply_to_play_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud apply-to-play-update">

    <h1>
        <?= Yii::t('backend', '预约信息') ?>
        <small>
            <?= $model->apply_to_play_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('common', '查看'), ['view', 'apply_to_play_id' => $model->apply_to_play_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
