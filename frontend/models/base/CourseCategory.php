<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\CourseCategory as BaseCourseCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "CourseCategory".
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
