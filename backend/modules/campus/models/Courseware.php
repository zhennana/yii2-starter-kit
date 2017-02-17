<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Courseware as BaseCourseware;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courseware".
 */
class Courseware extends BaseCourseware
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
