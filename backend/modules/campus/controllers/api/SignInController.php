<?php

namespace backend\modules\campus\controllers\api;

/**
* This is the class for REST controller "SignInController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SignInController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\modules\campus\models\SignIn';
}
