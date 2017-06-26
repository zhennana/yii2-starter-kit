<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\base\Feedback as BaseFeedback;
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
