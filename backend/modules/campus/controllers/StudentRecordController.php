<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\StudentRecord;
use yii\helpers\Html;
/**
* This is the class for controller "StudentRecordController".
*/
class StudentRecordController extends \backend\modules\campus\controllers\base\StudentRecordController
{

	function actionAjaxForm($type_id,$id){

		//var_dump($type_id,$id);exit;
		$model = new StudentRecord;

		$model = $model->getlist($type_id,$id);
		$option = "请选择";
		echo Html::tag('option',$option, ['value'=>'0']);
		foreach ($model as $key => $value) {
		 	 echo Html::tag('option',Html::encode($value),array('value'=>$key));
		}
	}
}
