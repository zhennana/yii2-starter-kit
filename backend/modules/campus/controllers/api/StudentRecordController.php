<?php

namespace backend\modules\campus\controllers\api;

/**
* This is the class for REST controller "StudentRecordController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class StudentRecordController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\modules\campus\models\StudentRecord';
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
    return ArrayHelper::merge(
    parent::behaviors(),
    [
    'access' => [
    'class' => AccessControl::className(),
    'rules' => [
    [
    'allow' => true,
    'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
    ]
    ]
    ]
    ]
    );
    }
}
