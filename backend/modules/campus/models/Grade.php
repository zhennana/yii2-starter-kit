<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\Grade as BaseGrade;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "grade".
 */
class Grade extends BaseGrade
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
/**
 * 模型返回添加数据
 * @return [type] [description]
 */
    public function fields()
    {
      $fields = parent::fields();
      $field = [
        'school_title'=>function($model){
            return $model->school->school_title;
        },
        'group_category_name'=>function($model){
            return $model->gradeCategory->name;
        }
      ];
      $fields = ArrayHelper::merge($fields,$field);
      unset($field);
      return $fields;
    }

    public function extraFields(){
       $fields = parent::extraFields();
       var_dump($fields);exit;
      return $fields;
    }
}
