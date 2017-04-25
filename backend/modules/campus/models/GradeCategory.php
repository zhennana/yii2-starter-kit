<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\GradeCategory as BaseGradeCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "grade_category".
 */
class GradeCategory extends BaseGradeCategory
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
        return array_merge(
                parent::fields(),
                [
                  'parent_label'=>function($model){
                      return isset($model->parents->name) ? $model->parents->name : '0' ;
                  },
                  'updated_at'=>function(){
                      return date('Y-m-d H:i:s',$this->updated_at);
                  },
                  'created_at'=>function(){
                    return date('Y-m-d H:i:s',$this->created_at);
                  },
                  'status_label'=>function(){
                    return GradeCategory::getStatusLabel($this->status);
                  }


                ]
            );
    }
}
