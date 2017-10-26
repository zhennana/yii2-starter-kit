<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\ActivationCode */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => '兑换码',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '兑换码'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="activation-code-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
