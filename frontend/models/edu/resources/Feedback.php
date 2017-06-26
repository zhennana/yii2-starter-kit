<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\base\Feedback as BaseFeedback;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "feedback".
 */
class Feedback extends BaseFeedback
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
