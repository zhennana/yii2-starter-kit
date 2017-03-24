<?php

namespace backend\modules\campus\controllers;
use Yii;
use backend\modules\campus\models\ApplyToPlay;

/**
* This is the class for controller "ApplyToPlayController".
*/
class ApplyToPlayController extends \backend\modules\campus\controllers\base\ApplyToPlayController
{
/**
 * *报名表单审核
 * @return [type] [description]
 */
    public function actionUpdateAudit(){
        if(\Yii::$app->request->isAjax){
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $value = $_POST;
          //var_dump($value);exit;
          $value['auditor_id'] = Yii::$app->user->identity->id;
          $model = ApplyToPlay::find()->where(['apply_to_play_id'=>$value['apply_to_play_id']])->one();
          if($model){
            $model->auditor_id = $value['auditor_id'];
            $model->status     = ApplyToPlay::APPLY_TO_PLAY_STATUS_SUCCEED;
            if($model->save()){
              return ['status'=>true];
            }else{
              return $model->getErrors();
            }
          }else{
              return ['message'=>'数据异常'];
          }
        }
    }
}
