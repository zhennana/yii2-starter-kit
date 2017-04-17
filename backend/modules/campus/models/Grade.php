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

      return ArrayHelper::merge(
             parent::fields(),
             [
                'school_title'=>function($model){
                    return isset($model->school->school_title) ? $model->school->school_title : '';
                },
                'group_category_name'=>function($model){
                    return isset($model->gradeCategory->name) ? $model->gradeCategory->name : '';
                },
                'status_label' => function($model){
                  //var_dump($model->status);exit;
                     return self::getStatusValueLabel($model->status);
                },
                'updated_at'  => function($model){
                    return date('Y-m-d H:i:s',$model->updated_at);
                },
                'created_at'  => function($model){
                  return date('Y-m-d H:i:s',$model->created_at);
                },
                'graduate_label'=>function($model){
                  return self::getGraduateValue($model->graduate);
                },
                'owner_label' =>function($model){
                  return self::getUserName($model->owner_id);
                }
             ]
        );
    }

    public function extraFields(){
      var_dump(1132);exit;
       return ArrayHelper::merage(
              parent::extraFields(),[
              'school'=>function(){
                 return '123';
              }]
              );
    }
}
