<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\StudentRecordKey;
use backend\modules\campus\models\StudentRecordValue;

/**
* This is the class for controller "StudentRecordValueController".
*/
class StudentRecordValueController extends \backend\modules\campus\controllers\base\StudentRecordValueController
{
    /**
     * 创建添加学生档案
     * @return [type] [description]
     */
    public function actionCreateValue(){
        $modelkey = StudentRecordKey::find()->asArray()->all();
        $data = [];
        foreach ($modelkey as $key => $value) {
            $data[$key]['key'] = $value;
            $data[$key]['value'] = new  StudentRecordValue();
        }
        if($_POST){
            $info = [];
            if($_POST['StudentRecordValue']){
                foreach ($_POST['StudentRecordValue'] as $key => $value) {
                    $modelvalue =  new  StudentRecordValue();
                    $modelvalue->load($value,'');
                    if(!$modelvalue->save()){
                        $info[$key] = $modelvalue;
                    };
                }
                if(empty($info)){
                    return $this->redirect(['user-to-grade/index']);
                }else{
                    return $this->render('_addFrom',['model'=>$data,'info'=>$info]);
                }
            }
        }
        return  $this->render('_addFrom',['model'=>$data]);
    }

}
