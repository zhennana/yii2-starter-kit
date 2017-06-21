<?php

namespace backend\modules\campus\controllers;
use Yii;
use yii\helpers\Html;
use backend\modules\campus\models\Course;
/**
* This is the class for controller "CourseController".
*/
class CourseController extends \backend\modules\campus\controllers\base\CourseController
{
	/**
	 * 二级联动
	 * @return [type] [description]
	 */
	public function actionAjaxForm(){
		$model = new Course;
		$model = $model->getlist($_GET['type_id'],$_GET['id']);
		echo Html::tag('option','请选择',['value'=> ""]);
		foreach ($model as $key => $value) {
		 	 echo Html::tag('option',Html::encode($value),array('value'=>$key));
		}

	}
}
