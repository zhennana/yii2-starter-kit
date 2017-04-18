<?php
namespace frontend\models\resources;

use yii\helpers\ArrayHelper;
use backend\modules\campus\models\CoursewareCategory as BaseCoursewareCategory;

/**
 * 
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
                # custom validation rules
            ]
        );
    }

    /**
     * [get_category 课件分类无限级递归]
     * @param  [type]  $model [description]
     * @param  integer $pid   [description]
     * @return [type]         [description]
     */
    /*
    public static function get_category($model, $pid = 0)
    {
        $data = [];
        foreach ($model as $key => $value) {
           if($model[$key]['parent_id'] == $pid){
                $value['sub_category'] = self::get_category($model,$value['category_id']);
                $data[] = $value;
            }
        }
        return $data;
    }
    */

}

?>