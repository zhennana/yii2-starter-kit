<?php

namespace backend\modules\campus\controllers;

use backend\modules\campus\models\StudentRecord;
use yii\helpers\Html;
use yii\helpers\Url;
use dmstr\bootstrap\Tabs;
/**
* This is the class for controller "StudentRecordController".
*/
class StudentRecordController extends \backend\modules\campus\controllers\base\StudentRecordController
{

	function actionAjaxForm($type_id,$id){
		//var_dump($_GET);exit;
		//var_dump($type_id,$id);exit;
		$model = new StudentRecord;

		$model = $model->getlist($type_id,$id);
		$option = "请选择";
		echo Html::tag('option',$option, ['value'=>'']);
		foreach ($model as $key => $value) {
		 	 echo Html::tag('option',Html::encode($value),array('value'=>$key));
		}
	}

	public function actionExport($student_record_id)
	{
		$this->layout = false;
		return $this->render('_export', [
			'model' => $this->findModel($student_record_id),
		]);
	}
	
}
