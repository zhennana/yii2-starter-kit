<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CoursewareCategory as BaseCoursewareCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "courseware_category".
 */
class CoursewareCategory extends BaseCoursewareCategory
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

             ]
        );
    }
    public function fields(){
      return ArrayHelper::merge(
        parent::fields(),
        [
          'updated_at'=>function(){
              return date('Y-m-d h:i:s',$this->updated_at);
          },
          'created_at'=>function(){
              return date('Y-m-d h:i:s',$this->created_at);
          },
          'status_label'=>function(){
              return self::StatusValueLabel($this->status);
          },
          'parent_label'=>function(){
              return isset($this->parentCoursewareCategory->name) ? $this->parentCoursewareCategory->name : '';
          }
        ]);
    }

    public function CascaderOption(){
           $model = self::find()->select(['category_id as value','name as label','parent_id'])
                                      ->where([])
                                      ->asArray()
                                      ->all();
            return self::init_data($model);
    }

    public  static function init_data($model,$pid = 0,$level = 1,$node = 2){
              $data = [];
              if($level > $node ){
                  return false;
              }
              foreach ($model as $key => $value) {
                  if($value['parent_id'] == $pid){
                      unset($model[$key]);
                      $children = self::init_data($model,$value['parent_id'],$level+1);
                      unset($value['parent_id']);
                      if(!empty($children)){
                        $value['children'] = $children;
                      }
                      
                      $data[] = $value;
                  }
                } 
                return $data; 
    }
}
