<?php

namespace frontend\models\gedu\resources;

use Yii;
use frontend\models\base\Collect as BaseCollect;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "collect".
 */
class Collect extends BaseCollect
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
