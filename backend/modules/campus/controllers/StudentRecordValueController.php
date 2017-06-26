<?php

namespace backend\modules\campus\controllers;
use backend\modules\campus\models\StudentRecordKey;
use backend\modules\campus\models\StudentRecordValue;
use backend\modules\campus\models\StudentRecordValueToFile;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;


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
//图片删除
    public function actionRemove($field_id){
       // var_dump($share_to_file_id);exit;
       if(\Yii::$app->request->isAjax){
            $model = StudentRecordValueToFile::findOne($field_id);
            if($model){
                  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                if($model->fileStorageItem){
                     $keys = $model->fileStorageItem->file_name;

                    $model->fileStorageItem->delete();
                    $model->delete();
                    $auth = new Auth(
                        \Yii::$app->params['qiniu']['wakooedu']['access_key'], 
                        \Yii::$app->params['qiniu']['wakooedu']['secret_key']
                      );
                    $bucketMgr = new BucketManager($auth);
                    $bucket    = \Yii::$app->params['qiniu']['wakooedu']['bucket'];
                    $err       = $bucketMgr->delete($bucket,$keys);
                    if($err != NULL){
                        \Yii::$app->getSession()->addFlash('error', $err->message());
                        return ['error'=>$err->message()];
                    }else{
                        \Yii::$app->getSession()->addFlash('info', '成功删除一张照片');
                        return ['status'=>'删除成功'];
                    }
                }
            }
            return ['error'=>'数据异常'];
        }else{
            return false;
        }
    }
}
