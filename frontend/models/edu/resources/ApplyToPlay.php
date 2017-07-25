<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\edu\ApplyToPlay as BaseApplyToPlay;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "apply_to_play".
 */
class ApplyToPlay extends BaseApplyToPlay
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
