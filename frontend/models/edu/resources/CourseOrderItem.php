<?php

namespace frontend\models\edu\resources;

use Yii;
use frontend\models\base\CourseOrderItem as BaseCourseOrderItem;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "couese_order_item".
 */
class CourseOrderItem extends BaseCourseOrderItem
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

    public function processCourseOrder($params)
    {
        var_dump($params);exit;
    }
}
