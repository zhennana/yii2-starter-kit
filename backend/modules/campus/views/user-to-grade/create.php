<?php

use yii\helpers\Html;
use backend\modules\campus\models\UserToGrade;
/**
* @var yii\web\View $this
* @var backend\modules\campus\models\UserToGrade $model
*/

$this->title = Yii::t('backend', '创建');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', '班级人员管理'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="giiant-crud user-to-grade-create">

    <h1>
    <?php
        if(isset($_GET['grade_user_type'])){
            if($_GET['grade_user_type'] == UserToGrade::GRADE_USER_TYPE_STUDENT ){
                echo Yii::t('backend', '创建班级学员');
            }elseif($_GET['grade_user_type'] == UserToGrade::GRADE_USER_TYPE_TEACHER){
                echo Yii::t('backend', '创建班级老师');
            }
        }else{
            echo Yii::t('backend', '创建班级人员');
        }
    ?>
       
        <small>
            <?= $model->user_to_grade_id ?>
        </small>
    </h1>

    <div class="clearfix crud-navigation">
        <div class="pull-left">
            <?=             Html::a(
            Yii::t('backend', '取消'),
            \yii\helpers\Url::previous(),
            ['class' => 'btn btn-default']) ?>
        </div>
    </div>

    <hr />

    <?= $this->render('_form', [
        'model' => $model,
        'info'  => isset($info)? $info : null,
    ]); ?>

</div>
