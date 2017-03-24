<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\School $model
*/

$this->title = Yii::t('backend', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '学校'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud school-create">

    <h1>
        <?= Yii::t('backend', '学校') ?>       
        <small>
            <?= $model->id ?>        
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=            
            Html::a(Yii::t('backend', '返回上一级'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
    'model' => $model,
    ]); ?>

</div>
