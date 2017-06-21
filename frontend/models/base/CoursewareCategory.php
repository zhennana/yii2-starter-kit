<?php
namespace frontend\models\base;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
}

