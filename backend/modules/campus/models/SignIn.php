<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\SignIn as BaseSignIn;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
//use backend\modules\campus\models\UserToGrade;

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

    public function getlist($type_id,$id =false){
        if($type_id == 1){
            $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
            return ArrayHelper::map($school,'school_id','school_title');
        }
        if($type_id == 2){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            //var_dump($grade);exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }

        if($type_id == 3){
            $course = Course::find()->where(['grade_id'=>$id,'status'=>Course::COURSE_STATUS_FINISH])->asArray()->all();
            return ArrayHelper::map($course,'course_id','title');
        }
        if(($type_id == 4) || ($type_id == 5)){
            $gradeUser = UserToGrade::find()->where(['grade_id' => $id]);
            if($type_id == 4){
                $gradeUser->andWhere(['grade_user_type'=> UserToGrade::GRADE_USER_TYPE_STUDENT]);
            }else{
                $gradeUser->andWhere(['grade_user_type'=> UserToGrade::GRADE_USER_TYPE_TEACHER]);
            }

            $gradeUser =  $gradeUser->asArray()->all();
            $users = [];
            foreach ($gradeUser as $key => $value) {
                    $users[$key]['user_id'] = $value['user_id'];
                    $users[$key]['username'] = SignIn::getUserName($value['user_id']);
                }
            return ArrayHelper::map($users,'user_id','username');
        }

        return false;
    }
}
