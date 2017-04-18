<?php
namespace frontend\models\resources;

use yii\helpers\ArrayHelper;
use backend\modules\campus\models\Courseware as BaseCourseware;

/**
 * 
 */
class Courseware extends BaseCourseware
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

    public function formatByApi($model, $file)
    {
        // var_dump($model);exit;
    }

}

?>
