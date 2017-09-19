<?php

namespace common\models;

use Yii;
use \common\models\base\Session as BaseSession;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "session".
 */
class Session extends BaseSession
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
