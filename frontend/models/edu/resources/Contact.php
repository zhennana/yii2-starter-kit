<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\base\Contact as BaseContact;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "Contact".
 */
class Contact extends BaseContact
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
