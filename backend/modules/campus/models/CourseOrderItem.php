<?php

namespace backend\modules\campus\models;

use Yii;
use \backend\modules\campus\models\base\CourseOrderItem as BaseCourseOrderItem;
use yii\helpers\ArrayHelper;
use cheatsheet\Time;
use backend\modules\campus\models\School;
use backend\modules\campus\models\UserToSchool;
use backend\modules\campus\models\Grade;
use common\models\User;

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

    public function getlist($type_id = false,$id =false)
    {
        if($type_id == 1){
            $grade = Grade::find()->where(['status'=>Grade::GRADE_STATUS_OPEN, 'school_id'=>$id])->asArray()->all();
            return ArrayHelper::map($grade,'grade_id','grade_name');
        }
        if($type_id == 2){
            $user = UserToSchool::find()
            ->where([
                'status'=>UserToSchool::SCHOOL_STATUS_ACTIVE, 
                'school_id'=>$id,
                'school_user_type'      => UserToSchool::SCHOOL_USER_TYPE_STUDENTS
                ])
            ->all();
            $data = [];
            foreach ($user as $key => $value) {
                if($value->user->username){
                    $data[$value->user_id] = $value->user->username;
                    continue;
                }
                if($value->user->realname){
                    $data[$value->user_id]  = $value->user->realname;
                }
            }
            return $data;
        }
        $school = School::find()->where(['status'=>School::SCHOOL_STATUS_OPEN])->asArray()->all();
        return ArrayHelper::map($school,'school_id','school_title');
      }
      //获取用户多有课时
       public static function userCourseNumber($user_id){
            return self::find()->where(['user_id'=>$user_id])->sum('presented_course + total_course');
       }

    public function batchOrder()
    {
        $info = new self;

        if (empty($this->days)) {
            $info->addError('days','充值天数不能为空');
            return $info;
        }
        if (empty($this->numbers)) {
            $info->addError('numbers','手机号码不能为空');
            return $info;
        }
        $numbers = explode("\r\n", $this->numbers);

        $userQuery = User::find()->where([
            'status' => User::STATUS_ACTIVE,
            'phone_number' => $numbers,
        ]);

        if ($userQuery->count() < 1) {
            $info->addError('count','用户不存在');
            return $info;
        }
        $users = $userQuery->all();
        foreach ($users as $key => $value) {
            $model = new self;
            $model->school_id      = 3;
            $model->user_id        = $value->id;
            $model->order_sn       = $this->builderNumber();
            $model->status         = self::STATUS_VALID;
            $model->payment        = self::PAYMENT_BACKEND;
            $model->payment_status = self::PAYMENT_STATUS_PAID;
            $model->total_course   = 0;
            $model->total_price    = $this->total_price ? $this->total_price : 0;
            $model->coupon_price   = 0;
            $model->real_price     = $this->total_price ? $this->total_price : 0;
            $model->days           = $this->days;
            $model->data           = 'Operator: [UID-'.(Yii::$app->user->isGuest?0:Yii::$app->user->identity->id).']';
            $model->expired_at     = $this->getRemainingTime($value->id, $this->days);
            if (!$model->save()) {
                $info->addError($key,$value->phone_number.' 保存失败');
                continue;
            }
        }
        return $info;
    }

    public function getRemainingTime($user_id, $days=0)
    {
        $time = time();
        $expired_at = $time+$days*Time::SECONDS_IN_A_DAY;
        $order = self::find()->where([
            'user_id'        => $user_id,
            'status'         => self::STATUS_VALID,
            'payment_status' => [self::PAYMENT_STATUS_PAID,self::PAYMENT_STATUS_PAID_CLIENT,self::PAYMENT_STATUS_PAID_SERVER],
        ])->orderBy('expired_at DESC')->one();

        if ($order && $order->expired_at > $time) {
            $expired_at = $order->expired_at+$days*Time::SECONDS_IN_A_DAY;
        }
        return $expired_at;
    }
}
