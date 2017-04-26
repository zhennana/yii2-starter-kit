<?php
namespace frontend\models\base;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\modules\campus\models\Courseware as BaseCourseware;
use backend\modules\campus\models\CoursewareToCourseware;
use backend\modules\campus\models\CoursewareCategory;

/**
 * 
 */
class Courseware extends BaseCourseware
{
    public $counts;
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
?>
