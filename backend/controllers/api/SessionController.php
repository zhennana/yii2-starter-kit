<?php

namespace backend\controllers\api;

/**
* This is the class for REST controller "SessionController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class SessionController extends \yii\rest\ActiveController
{
public $modelClass = 'common\models\Session';
}
