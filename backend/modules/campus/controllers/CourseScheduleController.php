<?php

namespace backend\modules\campus\controllers;
use \backend\modules\campus\models\CourseSchedule;
use \backend\modules\campus\models\Course;
use yii\helpers\ArrayHelper;
/**
* This is the class for controller "CourseScheduleController".
*/
class CourseScheduleController extends \backend\modules\campus\controllers\base\CourseScheduleController
{
    //时间对换
    public function actionTimeSwitch($grade_id,$school_id,$course_schedule_id,$course_id){
            $original_model  = CourseSchedule::findOne(['course_schedule_id'=>$course_schedule_id]);
            if($original_model == NULL){
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        try{
            $new_model = new CourseSchedule;
            $course_model = Course::find()
                    ->from(['course as c'])
                    ->select(['c.title','s.course_schedule_id','s.end_time','s.end_time','s.start_time','s.which_day'])
                    ->leftJoin('course_schedule as s','c.course_id = s.course_id')
                    ->andwhere([
                        'c.grade_id'=>$grade_id,
                        'c.school_id'=>$school_id,
                        ])
                    ->andwhere(['not',['c.course_id'=>$course_id]])
                    ->andwhere(['not',['c.status'=>20,'s.status'=>20]])
                    ->asArray()
                    ->all();
           if($_POST){
            //var_Dump($_POST);exit;
                if(isset($_POST['CourseSchedule'][0]) && isset($_POST['CourseSchedule'][1]) && !empty($_POST['CourseSchedule'][1]) && !empty($_POST[
                    'CourseSchedule'][0]) ){
                    $original_data = $_POST['CourseSchedule'][0];
                    $new_data      = $_POST['CourseSchedule'][1];
                    $original_model->load($original_data,'');
                    $original_model->save();
                    if(!$original_model->save()){
                        var_dump($original_model->getErrors());exit;
                        return $original_model->getErrors();
                    }
                    $new_model = CourseSchedule::findOne(['course_schedule_id'=>$new_data['course_schedule_id']]);
                    $new_model->load($new_data,'');
                    $new_model->save();
                    if(!$new_model->save()){
                        var_dump($new_model->getErrors());exit;
                        return $new_model->getErrors();
                    }
                    return $this->redirect('index');
                }
           }
        }
        catch (\Exception $e){
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $this->render('_time_switch',['original_model'=>$original_model,'new_model'=>$new_model,'course_model'=>$course_model]);
    }
    //批量关闭课程
    public function actionBatchClosed(){
        $info   = [];
        $info['code'] = 0;
        $ids = isset($_POST['ids']) ? $_POST['ids']:NULL;
        $data = [
            'message'=>[],
            'error'  =>[],
        ];
        if(!empty($ids) && is_array($ids)){

            foreach ($ids as $key => $course_schedule_id) {
                $model = CourseSchedule::findOne($course_schedule_id);

                if($model){
                    $model->status = CourseSchedule::COURSE_STATUS_FINISH;
                   if($model->save()){
                        $data['message'][] = $model;
                        Course::updateAll(['status'=>Course::COURSE_STATUS_FINISH],'course_id = '.$model->course_id);
                   }else{
                        $data['error'][] = $model->getErrors();
                   }
                }

            }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!isset($data['error'])){
            $info['code']    = 200;
            $info['success'] = count($data['message']);
        }else{
            $info['code']    = 400;
            $info['fail']    = count($data['message']);
            $info['success'] = count($data['error']);
        }
        return $info;
        }
    }
}
