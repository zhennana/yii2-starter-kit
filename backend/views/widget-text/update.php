<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetText */

$this->title = Yii::t('backend', '更新 ', [
    'modelClass' => 'Text Block',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '文本组件'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="text-block-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
