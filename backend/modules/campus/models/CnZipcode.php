<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CnZipcode as BaseCnZipcode;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cn_zipcode".
 */
class CnZipcode extends BaseCnZipcode
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
