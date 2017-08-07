<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseSchedule as BaseCourseSchedule;
use \backend\modules\campus\models\WorkRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "course_schedule".
 */
class CourseSchedule extends BaseCourseSchedule
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

    public function beforeSave($insert){
      //echo '<pre>';
      //var_dump(parent::beforeSave($insert));exit;
      if(parent::beforeSave($insert)){
        // custom code here...
        return true;
      }else{

      }
    }

    public function afterSave($insert,$changedAttributes){
      if(parent::beforeSave($insert)){
        if($this->which_day == date("Y-m-d",time())){
            $data = [
                'user_id'           =>$this->teacher_id,
                'title'             =>'上正课',
                'course_schedule_id'=>$this->course_schedule_id,
                'course_id'         =>$this->course_id,
                'school_id'         => $this->course->school_id,
                'grade_id'          => $this->course->grade_id,
                'type'              =>2,
            ];
            //当天排课添加老师工作记录.
            $work_record  = WorkRecord::find()->where($data)->one();
            if($this->status == self::COURSE_STATUS_OPEN){
                if(!$work_record){
                  $work_record = new WorkRecord;
                }
                $data['status'] = WorkRecord::STATUS_UNFINISHED;
                $work_record->load($data,'');
                $work_record->save();
                //var_dump($work_record->getErrors());
            }
            //当天时间如果关闭课程,删除老师工作记录
            if($this->status == self::COURSE_STATUS_DELECT){
                if($work_record){
                    $work_record->delete();
                }
            }
        }
      }
    }
}
