<?php

namespace frontend\models\gedu\resources;

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

}
