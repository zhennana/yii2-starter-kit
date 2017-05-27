<?php
namespace frontend\models\wedu\resources;

use Yii;
use frontend\models\base\CourseOrderItem as BaseCourseOrderItem;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\SignIn;

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

    /**
     * 统计一共多少节课
     * @return [type] [description]
     */
    public function statistical(){
   
        $model =  self::find()->select(['SUM(total_course + presented_course) as total_courses'])->where(['user_id'=>Yii::$app->user->identity->id,'payment_status'=>CourseOrderItem::PAYMENT_STATUS_PAID])->asArray()->one();
        $obove_course_count = $this->oboveCourse();
        $data = [];
        $data = [
            'total_courses' => '总共'.(int)$model['total_courses'].'节课',
            'presented_course' => '剩余'.((int)$model['total_courses'] -$obove_course_count).'节课',
        ];
        return $data; 
    }

    /**
     * 统计上了多少节课
     */
    public function oboveCourse($user_id = NULL){
      return SignIn::find()->where(['student_id'=>Yii::$app->user->identity->id])->count();
    }
}
