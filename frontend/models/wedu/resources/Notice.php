<?php

namespace frontend\models\wedu\resources;

use Yii;
use \frontend\models\base\Notice as BaseNotice;
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

    public function fields(){
      return ArrayHelper::merge(
         parent::fields(),
         [
              'updated_at'=> function(){
                  return date('Y-m-d H:i:s',$this->updated_at);
              },
              'created_at'=>function(){
                return  date('Y-m-d H:i:s',$this->created_at);
              }
         ]
    );
}
  /**
   * 消息通知
   * @param  [type] $category [description]
   * @return [type]           [description]
   */
    public function message($category,$school_id = NULL,$grade_id = NULL){
      $model = self::find()->select('message')
                ->where([
                    'category'=>$category,
                  ]);
      if($category == 2){
            $model->andWhere([
                'receiver_id'=>Yii::$app->user->identity->id
            ]);
        }else{
            $model->andWhere([
                'or',
                ['receiver_id'=> Yii::$app->user->identity->id],
                [
                'school_id'  => $school_id, 
                'grade_id'=> NULL ,
                'receiver_id' => Yii::$app->user->identity->id
                ],
                ['school_id'  => $school_id , 'grade_id' => $grade_id ,'receiver_id' => NULL],
            ]);
        }
        $model = $model->orderby(['created_at'=> SORT_DESC])
                ->asArray()->one();

        if($model == NULL){
            $model = [];
        }
      // var_dump(123);exit;
      return $model;
    }
/*
    public function messageCount($category){
        return self::find()
                ->where([
                    'status_check'=>self::STATUS_CHECK_NOT_LOOK ,
                    'category'=>$category,
                    'receiver_id'=>Yii::$app->user->identity->id
                    ])
                ->count();
    }
*/
    /*
    public function messageList(){
      return self::find()->select('message')->asArray()->all();
    }*/
}
