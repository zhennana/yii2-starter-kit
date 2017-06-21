<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\FileStorageItem $model
*/
    
$this->title = Yii::t('backend', '修改文件') . " " . $model->file_storage_item_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'File Storage Item'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->file_storage_item_id, 'url' => ['view', 'file_storage_item_id' => $model->file_storage_item_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud file-storage-item-update">

    <h1>
        <?= Yii::t('backend', 'File Storage Item') ?>
        <small>
                        <?= $model->file_storage_item_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'file_storage_item_id' => $model->file_storage_item_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
