<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\School $model
*/

$this->title = Yii::t('backend', '学校') . $model->id . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学校'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud school-update">

    <h1>
        <?= Yii::t('backend', '学校') ?>
        <small>
                        <?= $model->id ?>        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span> ' . Yii::t('backend', '查看'), ['view', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
