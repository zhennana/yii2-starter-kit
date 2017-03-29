<?php

namespace  frontend\models;

use Yii;
use  frontend\models\base\ApplyToPlay as BaseApplyToPlay;
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
