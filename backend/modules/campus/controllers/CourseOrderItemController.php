<?php

namespace backend\modules\campus\controllers;

use yii\helpers\Html;
use backend\modules\campus\models\CourseOrderItem;
/**
* This is the class for controller "CourseOrderItemController".
*/
class CourseOrderItemController extends \backend\modules\campus\controllers\base\CourseOrderItemController
{
    /**
     * 二级联动
     * @return [type] [description]
     */
    public function actionAjaxForm(){
        //var_dump($_GET);exit;
        $model = new CourseOrderItem;
        $model = $model->getlist($_GET['type_id'],$_GET['id']);
        foreach ($model as $key => $value) {
             echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }

    }
}
