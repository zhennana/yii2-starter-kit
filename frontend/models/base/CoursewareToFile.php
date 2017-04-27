<?php
namespace frontend\models\base;

use yii\helpers\ArrayHelper;
use backend\modules\campus\models\CoursewareToFile as BaseCoursewareToFile;

/**
 * 
 */
class CoursewareToFile extends BaseCoursewareToFile
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

?>
