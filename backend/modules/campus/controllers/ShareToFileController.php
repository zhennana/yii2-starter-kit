<?php

namespace backend\modules\campus\controllers;
use yii\helpers\Url;
use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;
use \backend\modules\campus\models\ShareToFile;

/**
* This is the class for controller "ShareToFileController".
*/
class ShareToFileController extends \backend\modules\campus\controllers\base\ShareToFileController
{
    /*
    public function actionDelete1($share_to_file_id){
       // var_dump($share_to_file_id);exit;
       if(\Yii::$app->request->isAjax){
            $model = $this->findModel($share_to_file_id);
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
    }*/
}
