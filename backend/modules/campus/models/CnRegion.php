<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CnRegion as BaseCnRegion;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cn_region".
 */
class CnRegion extends BaseCnRegion
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
