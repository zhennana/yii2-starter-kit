<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\CoursewareToCourseware as BaseCoursewareToCourseware;
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
}
