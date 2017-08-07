<?php

namespace frontend\models\base;

use Yii;
use \backend\modules\campus\models\SignIn as BaseSignIn;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "sign_in".
 */
class SignIn extends BaseSignIn
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
