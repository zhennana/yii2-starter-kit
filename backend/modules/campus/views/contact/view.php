<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use backend\modules\campus\models\Contact;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Contact $model
*/
$copyParams = $model->attributes;

$this->title = Yii::t('backend', '联系我们');
if(env('THEME') == 'gedu'){
    $this->title = Yii::t('backend', '意见反馈');

    }
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->contact_id, 'url' => ['view', 'contact_id' => $model->contact_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '查看');
?>
<div class="giiant-crud contact-view">

    <!-- flash message -->
    <?php if (\Yii::$app->session->getFlash('deleteError') !== null) : ?>
        <span class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <?= \Yii::$app->session->getFlash('deleteError') ?>
        </span>
    <?php endif; ?>

    <h1>
        <?= $this->title ?>
        <small>
            <?= $model->contact_id ?>
        </small>
    </h1>
    <div class="clearfix crud-navigation">

        <!-- menu buttons -->
        <div class='pull-left'>
           <!--  <? /* Html::a(
            '<span class="glyphicon glyphicon-pencil"></span> ' . Yii::t('backend', '更新'),
            [ 'update', 'contact_id' => $model->contact_id],
            ['class' => 'btn btn-info'])*/ ?>

            <?/* Html::a(
            '<span class="glyphicon glyphicon-copy"></span> ' . Yii::t('common', '复制'),
            ['create', 'contact_id' => $model->contact_id, 'Contact'=>$copyParams],
            ['class' => 'btn btn-success'])*/ ?>

            <?/* Html::a(
            '<span class="glyphicon glyphicon-plus"></span> ' . Yii::t('common', '创建'),
            ['create'],
            ['class' => 'btn btn-success'])*/ ?> -->
        </div>

        <div class="pull-right">
            <?= Html::a('<span class="glyphicon glyphicon-list"></span> '
            . Yii::t('backend', '返回列表'), ['index'], ['class'=>'btn btn-default']) ?>
        </div>

    </div>

    <hr />

    <?php $this->beginBlock('backend\modules\campus\models\Contact'); ?>

    
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'username',
            'phone_number',
            'email:email',
            'body',
            [
                'attribute' => 'auditor_id',
                'value'     => function($model){
                    return isset($model->user->username) ? $model->user->username : '';
                },
            ],
            [
                'attribute' => 'status',
                'value'     => Contact::getStatusLabel($model->status)
            ],
        ],
    ]); ?>

    
    <hr/>

  <!--   <? /* Html::a('<span class="glyphicon glyphicon-trash"></span> ' . Yii::t('backend', '删除'), ['delete', 'contact_id' => $model->contact_id],
    [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . Yii::t('backend', '确定要删除该项目吗？') . '',
    'data-method' => 'post',
    ]);*/ ?> -->
    <?php $this->endBlock(); ?>


    
    <?= Tabs::widget(
                 [
                     'id' => 'relation-tabs',
                     'encodeLabels' => false,
                     'items' => [
 [
    'label'   => '<b class=""># '.$model->contact_id.'</b>',
    'content' => $this->blocks['backend\modules\campus\models\Contact'],
    'active'  => true,
],
 ]
                 ]
    );
    ?>
</div>
