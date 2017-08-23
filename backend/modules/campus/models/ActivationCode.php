<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\ActivationCode as BaseActivationCode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "activation_code".
 */
class ActivationCode extends BaseActivationCode
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
