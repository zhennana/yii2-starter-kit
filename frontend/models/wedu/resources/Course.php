<?php
namespace frontend\models\wedu\resources;


use Yii;
use frontend\models\base\Course as BaseCourse;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "course".
 */
class Course extends BaseCourse
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
    /**
     * 需要签到的学生列表
     * @param  [type] $school_id [description]
     * @param  [type] $grade_id  [description]
     * @return [type]            [description]
     */
   public function userCourseSingInData($school_id,$grade_id){
          $start_time = time()+60*15;
          $end_time   = time()+60*30;
          $model = self::find()
                  ->select(['course_id','grade_id'])
                  ->with(['usersToGrades'=>function($model){
                        $model->andwhere(['status'=>1,'grade_user_type'=>10]);
                  }])
                  ->where(['school_id'=>$school_id,'grade_id'=>$grade_id])
                  //->andWhere(['between','start_time',$start_time,$end_time])
                  ->asArray()
                 ->all();
      //$commandQuery = clone $model; echo $commandQuery->createCommand()->getRawSql();exit();
          var_dump('<pre>',$model);exit;
   }
}
