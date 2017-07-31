<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\base\CourseCategory as BaseCourseCategory;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "CourseCategory".
 */
class CourseCategory extends BaseCourseCategory
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
     * [categoryList 课程分类列表]
     * @return [type] [description]
     */
    public function categoryList()
    {
        $model = self::find()->where(['status'=>self::STATUS_NORMAL,'parent_id' => 0])->asArray()->all();
        $data  =  self::formatByApi($model);
        return $data;
    }

    /**
     * [formatByApi 课程分类API数据格式化]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public static function formatByApi($params){
        $data = [];
        $child = [];
        foreach ($params as $key => $value) {
            $child = self::find()->where(['status'=>self::STATUS_NORMAL,'parent_id' => $value['category_id']])->asArray()->all();
            $temp = $value;
            $temp['child'] = $child;
            $data[] = $temp;
        }
        return $data;
    }
}
