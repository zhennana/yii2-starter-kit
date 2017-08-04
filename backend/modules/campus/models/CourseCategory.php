<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseCategory as BaseCourseCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "course_category".
 */
class CourseCategory extends BaseCourseCategory
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
