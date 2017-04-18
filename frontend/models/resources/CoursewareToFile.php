<?php
namespace frontend\models\resources;

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
