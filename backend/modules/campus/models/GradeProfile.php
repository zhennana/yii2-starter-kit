<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\GradeProfile as BaseGradeProfile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "grade_profile".
 */
class GradeProfile extends BaseGradeProfile
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
