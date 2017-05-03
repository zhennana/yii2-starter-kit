<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Notice as BaseNotice;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notice".
 */
class Notice extends BaseNotice
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
