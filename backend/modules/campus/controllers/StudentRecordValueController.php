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
     * 创建学生档案
     * @return [type] [description]
     */
    public function actionCreateValue(){
        $info = [];
//var_dump('<pre>',$_POST);exit;
        if($_POST){
            if($_POST['StudentRecordValue']){
               $model = new  StudentRecordValue();
                $info = $model->batchAdd($_POST['StudentRecordValue'],$_GET['student_record_id']);
                if(empty($info)){
                    return $this->redirect(['student-record/index']);
                }
            }
        }
        $modelkey = StudentRecordKey::find()->asArray()->all();
        $data = [];
       foreach ($modelkey as $key => $value) {
            $data[$key]['key'] = $value;
            $data[$key]['value']   = StudentRecordValue::find()
            ->where(['student_record_key_id'=>$value['student_record_key_id'],
                'student_record_id'=> $_GET['student_record_id']])
            ->one();
            $data[$key]['value'] = isset($data[$key]['value']) ? $data[$key]['value'] : new  StudentRecordValue();
        }
        return  $this->render('_addFrom',['model'=>$data,'info'=>$info]);
    }
}
