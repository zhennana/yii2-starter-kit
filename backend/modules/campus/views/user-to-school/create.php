<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\campus\models\UserToSchool */

$this->title = Yii::t('backend', 'Create {modelClass}', [
    'modelClass' => 'User To School',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User To Schools'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-to-school-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
