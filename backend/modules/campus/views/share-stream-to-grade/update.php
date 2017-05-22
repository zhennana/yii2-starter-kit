<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStreamToGrade $model
*/
    
$this->title = Yii::t('backend', 'Share Stream To Grade') . " " . $model->share_stream_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Share Stream To Grade'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->share_stream_id, 'url' => ['view', 'share_stream_id' => $model->share_stream_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud share-stream-to-grade-update">

    <h1>
        <?= Yii::t('backend', 'Share Stream To Grade') ?>
        <small>
                        <?= $model->share_stream_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'share_stream_id' => $model->share_stream_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
