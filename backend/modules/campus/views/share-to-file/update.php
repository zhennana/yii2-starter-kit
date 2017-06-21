<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\ShareToFile $model
*/
    
$this->title = Yii::t('models', 'Share To File') . " " . $model->share_to_file_id . ', ' . Yii::t('backend', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('models', 'Share To File'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->share_to_file_id, 'url' => ['view', 'share_to_file_id' => $model->share_to_file_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="giiant-crud share-to-file-update">

    <h1>
        <?= Yii::t('models', 'Share To File') ?>
        <small>
                        <?= $model->share_to_file_id ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', 'View'), ['view', 'share_to_file_id' => $model->share_to_file_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
