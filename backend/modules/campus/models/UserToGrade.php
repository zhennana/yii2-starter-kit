<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\UserToGrade as BaseUserToGrade;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users_to_grade".
 */
class UserToGrade extends BaseUserToGrade
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
