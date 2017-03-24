<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\School;
use yii\helpers\Html;
/**
* This is the class for controller "SchoolController".
*/
class SchoolController extends \backend\modules\campus\controllers\base\SchoolController
{
	
	public function actionList($typeid=false ,$id = false){
		//var_dump($typeid,$id);exit;
		$model = new School;
		$model = $model->getCityList($typeid,$id);
		$aa = "--请选择区--";
		if($typeid == 2){
			$aa = "--请选择市--";
		}
        echo Html::tag('option',$aa, ['value'=>'']) ;

        foreach($model as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
	}
}
