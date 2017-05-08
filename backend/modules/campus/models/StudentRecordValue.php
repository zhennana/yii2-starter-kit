<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\StudentRecordValue as BaseStudentRecordValue;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "student_record_value".
 */
class StudentRecordValue extends BaseStudentRecordValue
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
