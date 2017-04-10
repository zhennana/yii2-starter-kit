<?php

namespace backend\modules\campus\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\ApplyToPlay;
use common\models\school\School;


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

    public function actionSchoolLists($province_id)
    {
        $query = School::find()
            ->where(['parent_id' => 0])
            ->andWhere(['status' => School::SCHOOL_NORMAL]);
        $school = $query
            ->where(['province_id' => $province_id])
            ->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($query->count() > 0 || !empty($school)) {
            $school = ArrayHelper::map($school, 'id', 'school_short_title');
            return $school;
        }else{
            return ['0' => '暂无校区'];
        }
    }
}
