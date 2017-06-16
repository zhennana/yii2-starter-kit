<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Notice as BaseNotice;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "notice".
 */
class Notice extends BaseNotice
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
             parent::rules(),
             [
                  # custom validation rules
             ]
        );
    }

    public function batch_save($data)
    {
        $info = [];
        
        if(isset($data['school_id']) && is_array($data['school_id'])){
            $schoolIds  = $data['school_id']; unset($data['school_id']);
            foreach ($schoolIds as $key => $value) {
                $model = new Notice;
                $data['school_id'] = $value;
                $data['message_hash'] = md5($data['message']);
                $data['sender_id'] = Yii::$app->user->identity->id;
                $model->load($data,'');
               // var_dump($model->save());exit;
                if(!$model->save()){
                    $info[$key] = $model;
                }
            }
        }

        if(isset($data['grade_id']) && is_array($data['grade_id'])){
            $gradeIds  = $data['grade_id']; unset($data['grade_id']);
            foreach ($gradeIds as $key => $value) {
                $model = new Notice;
                $model->setScenario('grade');
                $data['grade_id'] = $value;
                $data['message_hash'] = md5($data['message']);
                $data['sender_id'] = Yii::$app->user->identity->id;
                $model->load($data,'');
               // var_dump($model->save());exit;
                if(!$model->save()){
                    $info[$key] = $model;
                }
            }
        }

        if(isset($data['receiver_id']) && is_array($data['receiver_id'])){
            $receiversIds  = $data['receiver_id']; unset($data['receiver_id']);
            foreach ($receiversIds as $key => $value) {
                $model = new Notice;
                 $model->setScenario('teacher');
                $data['receiver_id'] = $value;
                $data['message_hash'] = md5($data['message']);
                $data['sender_id'] = Yii::$app->user->identity->id;
                $model->load($data,'');
               // var_dump($model->save());exit;
                if(!$model->save()){
                    $info[$key] = $model;
                }
            }
        }
        return $info;
    }
    //下拉框数据
    public function getList($type_id = false,$id = false, $category = false){
        if($type_id == 1){
            $gradeInfo = Yii::$app->user->identity->getGrades(
                    Yii::$app->user->identity->id,
                    $id
                );
            //var_dump();exit;
            return ArrayHelper::map($gradeInfo,'grade_id','grade_name');
        }
        if($type_id == 2){
            if($category = 2){
                $user = Yii::$app->user->identity->getGradeToUser($id,10);

            }else{
                $user = Yii::$app->user->identity->getGradeToUser($id);
            }
           // var_dump(ArrayHelper::map($user,'id','username'));exit;
            return ArrayHelper::map($user,'id','username');
        }
    }
}
