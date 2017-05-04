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

    public static function cascaderOption(){
           $model = self::find()->select(['category_id as value','name as label','parent_id'])
                      ->where(['status'=>self::CATEGORY_STATUS_OPEN])
                      ->asArray()
                      ->all();
            return self::initData($model);
    }
    /**
     * 获取父分类
     * @param  [type]  $model [description]
     * @param  integer $pid   [description]
     * @param  integer $level [description]
     * @param  integer $node  [description]
     * @return [type]         [description]
     */
    public  static function initData($model,$pid = 0,$level = 1,$node = 2){
              $data = [];
              $children = [];
              if($level > $node){
                return $data;
              }
              foreach ($model as $key => $value){
                  if($value['parent_id'] == $pid){
                      unset($model[$key]);
                      unset($value['parent_id']);
                      $children = self::initData($model,$value['value'],$level+1);
                      
                      if(!empty($children)){
                        $value['children'] = $children;
                      }

                      $data[] = $value;
                  }
                  
                } 
                return $data; 
    }
}
