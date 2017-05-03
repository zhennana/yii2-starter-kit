<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\ShareStream as BaseShareStream;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "share_stream".
 */
class ShareStream extends BaseShareStream
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
