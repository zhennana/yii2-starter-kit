<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\StudentRecordKey as BaseStudentRecordKey;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "student_record_key".
 */
class StudentRecordKey extends BaseStudentRecordKey
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
