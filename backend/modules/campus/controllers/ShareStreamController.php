<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\ShareStreamToGrade;
use backend\modules\campus\models\ShareStream;

/**
* This is the class for controller "ShareStreamController".
*/
class ShareStreamController extends \backend\modules\campus\controllers\base\ShareStreamController
{

    public function actionCreate(){
        $model = new ShareStream;
        $data = [];
        //$ShareStreamToGrade = new ShareStreamToGrade;
        if($_POST){
            $data = $model->batch_create($_POST);
            // if(!empty($data->getErrors())){
            //     return $this->render('create',['model'=>$model,'model1'=>$data]);
            // }
        }
        return $this->render('create',['model'=>$model,'model1'=>$data]);
    }
}
