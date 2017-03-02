<?php

namespace backend\modules\campus\controllers;
use Yii;
use backend\modules\campus\models\Contact;
/**
* This is the class for controller "ContactController".
*/
class ContactController extends \backend\modules\campus\controllers\base\ContactController
{
	/**
	 * *俩系我们
	 * @return [type] [description]
	 */
    public function actionUpdateAudit(){
        if(\Yii::$app->request->isAjax){
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $value = $_POST;
          //var_dump($value);exit;
          $value['auditor_id'] = Yii::$app->user->identity->id;
          $model = Contact::find()->where(['contact_id'=>$value['contact_id']])->one();
          if($model){
            $model->auditor_id = $value['auditor_id'];
            $model->status     = Contact::CONTACT_STATUS_APPROVED;
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
