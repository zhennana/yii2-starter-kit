<?php

namespace backend\modules\campus\controllers;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use backend\modules\campus\models\Course;
use backend\modules\campus\models\CoursewareCategory;
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
		//echo Html::tag('option','请选择',['value'=> ""]);
		foreach ($model as $key => $value) {
		 	 echo Html::tag('option',Html::encode($value),array('value'=>$key));
		}

	}
	//批量排课
	public function actionCourseBatch(){

		$model = new Course;
		//var_Dump($model);exit;
		$model->scenario = 'course_view';
		$category = CoursewareCategory::find()
						 ->andwhere([
							'status'=>10
						])->andWhere(['not','parent_id'=>0])->all();
		$schools = Yii::$app->user->identity->schoolsInfo;
		//var_dump();exit;
    	$schools = ArrayHelper::map($schools,'school_id','school_title');
    	$category = ArrayHelper::map($category,'category_id','name');
    	if($model->load($_POST) && Yii::$app->request->isAjax){
    		//return $model->load($_POST);
    		//return $model->Datavalidations($_POST['Course']);
    		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    		return $model->CourseBatch($_POST);
    	}
		return $this->render('_course_batch',
			[
			'model'=>$model,
			'schools'=>$schools,
			'categorys'=>$category
			]);
	}
//Datavalidations
	public function actionCourseValidations(){
		$model = new Course;
		$model->scenario = 'course_view';
		//var_Dump($_POST);exit;
		if($_POST){
			Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $model->Datavalidations($_POST['Course']);
		}
	}
}
