<?php

namespace frontend\modules\api\v1\resources;

use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\CourseOrderItem as BaseCourseOrderItem;
/**
 * @author Eugene Terentev <eugene@terentev.net>
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

    public function createActivationOrder($codeModel,$params)
    {
        $info = [
            'errorno' => '0',
            'message' => '',
            'model' => null,
        ];
        $model = new self;
        if (!$codeModel) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','无效的激活码');
            return $info;
        }

        $model->order_sn       = $this->builderNumber();
        $model->school_id      = $codeModel->school_id;
        $model->user_id        = $params['user_id'];
        $model->introducer_id  = $codeModel->introducer_id;
        $model->payment        = $codeModel->payment;
        $model->status         = self::STATUS_VALID;
        $model->payment_status = self::PAYMENT_STATUS_PAID;
        $model->total_price    = $codeModel->total_price;
        $model->real_price     = $codeModel->real_price;
        $model->coupon_price   = $codeModel->coupon_price;
        $model->coupon_type    = $codeModel->coupon_type;
        $model->total_course   = 0;
        if (!$model->save()) {
            $info['errorno'] = __LINE__;
            $info['message'] = $model->getErrors();
            return $info;
        }

        $info['model'] = $model;
        return $info;
    }

}
