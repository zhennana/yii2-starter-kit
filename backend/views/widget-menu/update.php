<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */

$this->title = Yii::t('backend', '更新 ', [
    'modelClass' => 'Widget Menu',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '菜单组件'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="widget-menu-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
