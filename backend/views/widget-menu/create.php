<?php
/* @var $this yii\web\View */
/* @var $model common\models\WidgetMenu */

$this->title = Yii::t('backend', '创建', [
    'modelClass' => 'Widget Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '菜单组件'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widget-menu-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
