<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\Course as BaseCourse;
use yii\helpers\ArrayHelper;

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
}
