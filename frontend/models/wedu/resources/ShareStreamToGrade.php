<?php

namespace frontend\models\wedu\resources;

use Yii;
use \frontend\models\base\ShareStreamToGrade as BaseShareStreamToGrade;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "share_stream_to_grade".
 */
class ShareStreamToGrade extends BaseShareStreamToGrade
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
