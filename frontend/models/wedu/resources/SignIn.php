<?php

namespace frontend\models\wedu\resources;

use Yii;
use frontend\models\base\SignIn as BaseSignIn;
use yii\helpers\ArrayHelper;
use frontend\models\wedu\resources\Course;
use backend\modules\campus\models\WorkRecord;
use backend\modules\campus\models\CourseSchedule;
use common\components\APush\APush;
/**
 * This is the model class for table "sign_in".
 */
class SignIn extends BaseSignIn
{

public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }

    public function batch_add($params){
       $data = [];
       if(empty($params)){
           $data['error'][] = '数据不能为空';
        }
        $is_change_course = true;//更改课程状态
        foreach ($params['SignIn'] as $key => $value) {
            $model = new $this;
            $is_check = self::find()
                  ->where([
                    'school_id'=>$params['school_id'],
                    'grade_id'=>$params['grade_id'],
                    'course_id'=>$params['course_id'],
                    'student_id'=> $value['student_id'],
                    'course_schedule_id'=>$params['course_schedule_id'],
                    ]);
            if($is_check->count() == 0){
                $value['school_id'] = $params['school_id'];
                $value['course_id'] = $params['course_id'];
                $value['grade_id'] = $params['grade_id'];
                $value['course_schedule_id'] = $params['course_schedule_id'];
                $model->load($value,'');
                if(!$model->save()){
                  $data['error'][$key] = $model->getErrors();
                }else{
                  $message = [];
                  // 添加学生档案
                  if($model->type_status == 10){
                      $this->addStudentRecord([
                            'user_id'   => $model->student_id,
                            'school_id' => $model->school_id,
                            'grade_id'  => $model->grade_id,
                            'course_id' => $model->course_id,
                            'course_schedule_id'=>$model->course_schedule_id,
                            'title'     => '',
                            'status'    => 1,
                        ]);
                      if($is_change_course == true){
                        $is_change_course = false;
                        //更新课程状态
                        Course::updateAll(['status'=>Course::COURSE_STATUS_FINISH],'course_id='.$model->course_id);
                        CourseSchedule::updateAll(['status'=>CourseSchedule::COURSE_STATUS_FINISH],'course_schedule_id='.$model->course_schedule_id);
                      }

                    //发送推送消息
                    $userProfile = Yii::$app->user->identity->getUserProfile($model->student_id);
                    if(isset($userProfile->clientid) && isset($userProfile->client_source_type)){
                        $message[] = [
                              'client_source_type'=> $userProfile->client_source_type,
                              'cid'               => $userProfile->clientid,
                              'message'           => [
                                      'title' =>'上课通知',
                                      'body'  =>'您的孩子签到了:'.$model->course->title
                              ]
                        ];
                    }

                  }
                  $data['message'][$key] = $model;
                }
        }else{
          //这里再次签到直接返回
          $data['message'][$key]  = $is_check->one();
        }
        //更新老师工作接口接口
        if($data['message']){
            $WorkRecord = WorkRecord::find()->andwhere([
              'course_id'=>$params['course_id'],
              'type'=>WorkRecord::TYPE_TWO,
              'grade_id'=>$params['grade_id'],
              'status'=> WorkRecord::STATUS_UNFINISHED])
            ->one();
            if($WorkRecord){
               $WorkRecord->status = 10;
               $WorkRecord->save();
            }
        }

    }
    //签到个推
    if(!empty($message)){
        $APush = new APush;
        $APush->pushMessageToSingleBatch($message);
    }
     return $data;
  }

    /**
     * 缺勤记录格式化
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function formatData($params){
        if(empty($params)){
            return [];
        }
       // var_dump();exit;
        $data = [];
        foreach ($params as $key => $value) {
            if(!isset($data[$value->course_id][$key]['title'])){
                $data[$value->course_id]['course_schedule_id']         = $value['course_schedule_id'];
                $data[$value->course_id]['course_title']               = isset($value->course->title)? $value->course->title : '';
                $data[$value->course_id]['created_at']                 = isset($value->course->start_time) ?$value->course->start_time  : '';
                $data[$value->course_id]['sign_in_count']              = (int)self::singInCount($value->course_id);
                $data[$value->course_id]['already_signed_count']       = (int)self::singInCount($value->course_id,true);
                //$data[$value->course_id]['absenteeism_count']   = count($params);
            }
            $data[$value->course_id]['absence_user'][]['username']      = Yii::$app->user->identity->getUserName($value->student_id);
            $data[$value->course_id]['absenteeism_count']   =  count($data[$value->course_id]['absence_user']);
        }
        sort($data);
        return $data;
    }
    /**
     * 
     * @param [type] $data [description]
     */
    public function addStudentRecord($data){
        $studentRecord  = \backend\modules\campus\models\StudentRecord::find()->where($data)->one();
        if(!$studentRecord){
            $studentRecord = new \backend\modules\campus\models\StudentRecord;
            $studentRecord->load($data,'');
            $studentRecord->save();
           // var_dump($studentRecord->getErrors());exit;
        }
        return true;
    }
    /**
     * *
     * @return [type] [description]
     */
    // public function closeCourse($course_id){

    // }
/**
 * 签到表详情详情
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
/*
    public function details($id){
      $model = self::find()
        ->where(['signin_id'=>$id])
        ->with([
          'courseOrder'=>function($model){
              $model->select(['SUM(total_course + presented_course) as course_count','created_at'])
              ->orderBy(['created_at'=>'SORT_DESC']);
          },
          'signIns'=>function($model){
              $model->select(["count(signin_id) as above_course"]);
              $model->where(['type_status'=>SignIn::TYPE_STATUS_MORMAL]);
          },
          'grade'=>function($model){
            $model->select(['grade_name']);
          },
          'school'=>function($model){
              $model->select(['school_title']);
          },
          'user'=>function($model){
             $model->select(['username','id','realname','phone_number']);
             $model->with('userProfile');
        }])
        ->asArray()->one();
        $data = [];
        if($model){
           $data = [
              'signin_id'     => (int)$model['signin_id'],
              'school_id'     => (int)$model['school_id'],
              'school_title'  => $model['school']['school_title'],
              'grade_id'      => (int)$model['grade_id'],
              'grade_name'    => $model['grade']['grade_name'],
              'course_id'     => (int)$model['course_id'],
              'student_id'    => (int)$model['student_id'],
              'realname'      => $model['user']['realname'],
              'username'      => $model['user']['username'],
              'gender'        => $model['user']['userProfile']['gender'],
              'course_count'  => (int)$model['courseOrder']['course_count'],
              'above_course'  => (int)$model['signIns']['above_course'],
              'remaining_courses'=> (int)$model['courseOrder']['course_count'] -(int)$model['signIns']['above_course'],
              'created_at'    => $model['courseOrder']['created_at'],
              'phone_number'  => $model['user']['phone_number'],
          ];
        }
        return $data;
    }
*/
}
