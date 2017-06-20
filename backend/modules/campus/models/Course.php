<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Course as BaseCourse;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\Grade;
use backend\modules\campus\models\UserToGrade;

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

  public function getlist($type_id = false,$id =false){
        if($type_id == 1){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            //var_dump($grade);exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        if($type_id == 2){
            $UserToGrade = UserToGrade::find()
                      ->where([
                        'grade_id'=>$id,
                        'grade_user_type'=>20
                        ])
                      ->with('user')
                      ->all();
          $data = [];
          foreach ($UserToGrade as $key => $value) {
                $data[$value['user_id']] = $value['user']['username'];
          }
          return $data;
        }
        /*
        $school_id = Yii::$app->user->identity->getSchoolOrGrade();
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN]);
        if($school_id != 'all'){
            $school->andwhere(['school_id'=>$school_id]);
        }
        $school = $school->asArray()->all();
        return ArrayHelper::map($school,'school_id','school_title');*/
      }
}
