<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
*/

$this->title = Yii::t('backend', '发布分享');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Share Streams'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud share-stream-create">

    <h1>
        <?= Yii::t('backend', 'Share Stream') ?>
        <small>
            <?= $model->share_stream_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('backend', 'Cancel'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    'model1'=>$model1
    ]); ?>

</div>
