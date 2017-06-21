<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('backend', '更新: ', [
    'modelClass' => 'Page',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '静态页面'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="page-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
