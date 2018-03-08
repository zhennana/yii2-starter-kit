<?php

use yii\helpers\Html;

/**
* @var yii\web\View $this
* @var backend\modules\campus\models\GradeCategroy $model
*/
$title = env('THEME') == 'gedu' ? Yii::t('backend', '年级管理') :Yii::t('backend', '班级分类管理') ;
    
$this->title = $title . " " . $model->name . ', ' . Yii::t('backend', '更新');
$this->params['breadcrumbs'][] = ['label' => $title, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => (string)$model->name, 'url' => ['view', 'grade_category_id' => $model->grade_category_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', '更新');
?>
<div class="giiant-crud grade-categroy-update">

    <h1>
        <?php
             if(env('THEME') == 'gedu'){
                echo Yii::t('backend', '年级管理');
            }else{
                echo Yii::t('backend','班级分类管理');
            } ?>
        <small>
                <?= $model->name ?>
        </small>
    </h1>

    <div class="crud-navigation">
        <?= Html::a('<span class="glyphicon glyphicon-file"></span> ' . Yii::t('backend', '查看'), ['view', 'grade_category_id' => $model->grade_category_id], ['class' => 'btn btn-default']) ?>
    </div>

    <hr />

    <?php echo $this->render('_form', [
        'model' => $model,
        'parent_category' => $parent_category,
    ]); ?>

</div>
