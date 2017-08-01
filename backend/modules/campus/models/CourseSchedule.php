<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseSchedule as BaseCourseSchedule;
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
}
