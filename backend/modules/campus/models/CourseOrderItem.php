<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseOrderItem as BaseCourseOrderItem;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\UserToSchool;
use backend\modules\campus\models\Grade;

/**
 * This is the model class for table "couese_order_item".
 */
class CourseOrderItem extends BaseCourseOrderItem
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

    public function getlist($type_id = false,$id =false)
    {
        if($type_id == 1){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        if($type_id == 2){
            $user = UserToSchool::find()
            ->where([
                'status'=>UserToSchool::SCHOOL_STATUS_ACTIVE, 
                'school_id'=>$id,
                'school_user_type'      => UserToSchool::SCHOOL_USER_TYPE_STUDENTS
                ])
            ->all();
            $data = [];
            foreach ($user as $key => $value) {
                if($value->user->username){
                    $data[$value->user_id] = $value->user->username;
                    continue;
                }
                if($value->user->realname){
                    $data[$value->user_id]  = $value->user->realname;
                }
            }
            return $data;
        }
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
        return ArrayHelper::map($school,'school_id','school_title');
      }
      //获取用户多有课时
       public static function userCourseNumber($user_id){
            return self::find()->where(['user_id'=>$user_id])->sum('presented_course + total_course');
       }
}
