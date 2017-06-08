<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\StudentRecordKey;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use yii\web\Response;

/**
* This is the class for controller "StudentRecordKeyController".
*/
class StudentRecordKeyController extends \backend\modules\campus\controllers\base\StudentRecordKeyController
{

    function actionAjaxForm($type_id,$id){
        //var_dump($_GET);exit;
        //var_dump($type_id,$id);exit;
        $model = new StudentRecordKey;

        $model = $model->getlist($type_id,$id);
        $option = "请选择";
        echo Html::tag('option',$option, ['value'=>'']);
        foreach ($model as $key => $value) {
             echo Html::tag('option',Html::encode($value),array('value'=>$key));
        }
    }

        /**
     * 弹框创建 标题
     * @return [type] [description]
     */
    public function actionAjaxStudentKey(){
       // return 123;
        $model = new StudentRecordKey;
        if($model->load($_POST)){
           try {
                if ($model->save()) {
                    return 200;
                }else{
                    return $model->getErrors();
                }
            } catch (\Exception $e) {
                $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
                //var_dump($msg);exit;
                $model->addError('_exception', $msg);
                return $model->getErrors();
                //return $this->renderAjax('create', ['model' => $model]);
            }
        }
            return $this->renderAjax('create', ['model' => $model]);
        }

}
