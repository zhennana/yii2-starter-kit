<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\Contact $model
*/
    
$this->title = Yii::t('common', 'Contact') . " " . $model->contact_id . ', ' . Yii::t('common', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Contact'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->contact_id, 'url' => ['view', 'contact_id' => $model->contact_id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Edit');
?>
<div class="giiant-crud contact-update">

    <h1>
        <?= Yii::t('common', 'Contact') ?>
        <small>
                        <?= $model->contact_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('common', 'View'), ['view', 'contact_id' => $model->contact_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
