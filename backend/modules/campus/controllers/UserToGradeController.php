<?php

namespace backend\modules\campus\controllers;
use Yii;
use yii\helpers\Html;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\UserToGrade;
/**
* This is the class for controller "UserToGradeController".
*/
class UserToGradeController extends \backend\modules\campus\controllers\base\UserToGradeController
{
    /**
     * 二级联动
     * @return [type] [description]
     */
    public function actionAjaxForm(){
        //var_dump($_GET);exit;
        $model = new UserToGrade;
        $model = $model->getlist($_GET['type_id'],$_GET['id']);
        foreach ($model as $key => $value) {
             echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }
}
