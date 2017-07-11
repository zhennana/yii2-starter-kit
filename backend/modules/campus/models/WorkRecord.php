<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\WorkRecord as BaseWorkRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "work_recourd".
 */
class WorkRecord extends BaseWorkRecord
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
