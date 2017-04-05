<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CoursewareCategory as BaseCoursewareCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courseware_category".
 */
class CoursewareCategory extends BaseCoursewareCategory
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
