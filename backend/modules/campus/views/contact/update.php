<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Contact $model
*/
    
$this->title = Yii::t('backend', '联系我们') . " " . $model->contact_id . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '联系我们'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->contact_id, 'url' => ['view', 'contact_id' => $model->contact_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud contact-update">

    <h1>
        <?= Yii::t('backend', '联系我们') ?>
        <small>
            <?= $model->contact_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '查看'), ['view', 'contact_id' => $model->contact_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
