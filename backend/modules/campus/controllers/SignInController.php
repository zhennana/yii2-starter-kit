<?php

namespace backend\modules\campus\controllers;

use backend\modules\campus\models\SignIn;
use backend\modules\campus\models\Course;
use backend\modules\campus\models\CourseSchedule;
use yii\helpers\Html;
/**
* This is the class for controller "SignInController".
*/
class SignInController extends \backend\modules\campus\controllers\base\SignInController
{
	public function actionAudit()
	{
		// var_dump($_POST);
		$info                 = [];
		$info['code']         = 0;
		$value['ids']         = isset($_POST['ids']) ? $_POST['ids'] : NULL;
		$value['operator_id'] = \Yii::$app->user->identity->id;

		if (isset($value['ids'] ) && !empty($value['ids']) && isset($value['operator_id'])) {
			$info['count'] = count($value['ids']);
			$audit_count = SignIn::updateAll(
				[
					'auditor_id' => $value['operator_id'],
					'updated_at' => time(),
				],
				[	// 审核条件
					'signin_id'  => $value['ids'],
					'auditor_id' => 0,
				]
			);

			if ($audit_count == $info['count']) {
				$info['code']    = 200;
				$info['success'] = $info['count'];
			}else{
				$info['code']    = 400;
				$info['fail']    = $info['count']-$audit_count;
				$info['success'] = $info['count']-$info['fail'];
			}
		}
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $info;
	}
	function actionAjaxForm($type_id,$id){
		//var_dump($_GET);exit;
		//var_dump($type_id,$id);exit;
		$model = new SignIn;

		$model = $model->getlist($type_id,$id);
		$option = "请选择";
		echo Html::tag('option',$option, ['value'=>'']);
		foreach ($model as $key => $value) {
		 	 echo Html::tag('option',Html::encode($value),array('value'=>$key));
		}
	}
	//补课
	public function  actionBuke($signin_id){
		$model = $this->findModel($signin_id);
		if($_POST){
			return 123;
		}
		return $this->render('_buke', [
				'model' => $model,
				]);
	}
//ajax-buke
	public function actionAjaxBuke(){
		$courseware_id = \Yii::$app->request->get('courseware_id');
		$grade_id      =  \Yii::$app->request->get('grade_id');
		if($courseware_id === NULL && $grade_id === NULL){
			return '';
		}
		$model = new Course;
		$data = [
			'courseware_id'=>$courseware_id,
			'grade_id'	   =>$grade_id,
		];
		$dataProvider =$model->CourseSchedule($data,true,false);
		//var_dump($dataProvider);exit;
		if($dataProvider){
			$data = [
				'teacher_id'   		=>$dataProvider['teacher_id'],
				'course_id'	  	    =>$dataProvider['course_id'],
				'course_schedule_id'=>$dataProvider['course_schedule_id'],
				'teacher_name'		=> \Yii::$app->user->identity->getUserName($dataProvider['teacher_id']),
				'course_title'		=> $dataProvider['title'],
			];
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $data;
		}
		return true;

	}
}
