<?php

use yii\helpers\Html;
//var_dump($message);exit;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareStream $model
*/

$this->title = Yii::t('backend', '创建分享消息流');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '创建分享消息流'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($shareToGrade);exit;
?>
<div class="giiant-crud share-stream-create">

    <h1>
        <?= Yii::t('backend', '创建分享消息流') ?>
        <small>
            <?= $model->share_stream_id ?>
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

    <?= $this->render('_form', [
    'model' => $model,
    'shareToGrade'=>$shareToGrade,
    'message'=>isset($message) ? $message : NULL,
    ]); 
    ?>

</div>
