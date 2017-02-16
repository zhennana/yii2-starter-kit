<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\UesrToSchool as BaseUesrToSchool;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "users_to_school".
 */
class UesrToSchool extends BaseUesrToSchool
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
