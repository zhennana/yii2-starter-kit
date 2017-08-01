<?php

namespace frontend\models\gedu\resources;
use Yii;
use \frontend\models\base\CoursewareToCourseware as BaseCoursewareToCourseware;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courseware_to_courseware".
 */
class CoursewareToCourseware extends BaseCoursewareToCourseware
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

  public function getCourseware(){
        return $this->hasOne(\frontend\models\edu\resources\Courseware::className(),['courseware_id'=>'courseware_id']);
  }
}
