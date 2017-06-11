<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseOrderItem as BaseCourseOrderItem;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
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
            // var_dump($grade);exit;
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
        return ArrayHelper::map($school,'school_id','school_title');
      }
}
