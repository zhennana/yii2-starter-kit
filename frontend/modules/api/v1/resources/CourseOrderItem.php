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
                ['expired_at','required'],
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
        $model->grade_id       = $codeModel->grade_id;
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
        $model->expired_at     = $codeModel->expired_at;
        if (!$model->save()) {
            $info['errorno'] = __LINE__;
            $info['message'] = $model->getErrors();
            return $info;
        }

        $info['model'] = $model;
        return $info;
    }

    public function processAppleOrder()
    {
        $info = [];
        $params = Yii::$app->request->post();

        $params['user_id']  = Yii::$app->user->identity->id;
        $params['order_sn'] = $this->builderNumber();
        if (isset($params['expired_at']) && !empty($params['expired_at'])) {
            $remaining_time = $this->getRemainingTime($params['user_id']);
            $expired_at = time()+$params['expired_at']+$remaining_time;
        }else{
            $expired_at = time()+\cheatsheet\Time::SECONDS_IN_A_MONTH;
        }
        $params['expired_at'] = $expired_at;

        // 验证数据
        $validate = $this->validateAppleOrder($params);
        if(isset($validate['errno']) && $validate['errno'] !== 0){
            return $validate;
        }

        // 创建订单
        $info = $this->createOrderOne($validate);
        return $info;
    }

    public function validateAppleOrder($params)
    {
        $info = [
            'errno'   => 0,
            'message' => ''
        ];

        if (!isset($params['school_id']) || empty($params['school_id']) || $params['school_id'] != 3) {
            $params['school_id'] = 3;
        }

        // 验证订单状态
        if (!isset($params['status']) || !in_array($params['status'],[self::STATUS_VALID])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Order Status Is Not Legal!';
            return $info;
        }

        // 验证支付方式
        if (!isset($params['payment']) || !in_array($params['payment'],[self::PAYMENT_ONLINE,self::PAYMENT_ALIPAY,self::PAYMENT_WECHAT, self::PAYMENT_OFFLINE, self::PAYMENT_APPLEPAY, self::PAYMENT_APPLEPAY_INAPP])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Payment Type Is Not Legal!';
            return $info;
        }else{
            $params['payment'] = (int) $params['payment'];
        }

        // 验证支付状态
        if (!isset($params['payment_status']) || empty($params['payment_status'])) {
            $params['payment_status'] = self::PAYMENT_STATUS_PAID;
        }

        // 验证优惠类型和优惠价格
        if (isset($params['coupon_type']) && !empty($params['coupon_type']) && isset($params['coupon_price']) && !empty($params['coupon_price'])) {
            if ($params['coupon_price'] != $params['total_price']-$params['real_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = 'Coupon Price Is Not Legal!';
                return $info;
            }
        }else{
            $params['coupon_price'] = 0;
        }

        // 验证实际付款
        if (isset($params['real_price']) && !empty($params['real_price'])) {
            if ($params['real_price'] != $params['total_price'] - $params['coupon_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = 'Real Price Is Not Legal!';
                return $info;
            }
        }

        // 
        if (!isset($params['total_course']) || empty($params['total_course'])) {
            $params['total_course'] = 0;
        }

        if ($info['errno'] == 0) {
            return $params;
        }

        return $info;
    }

    /**
     * [createOrderOne 创建一个订单]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function createOrderOne($params)
    {
        $info = [
            'errno'   => 0,
            'message' => ''
        ];

        $model = new $this;

        if ($model->load($params,'') && $model->save($params)) {
            return $model;
        }

        $info['errno']   = __LINE__;
        $info['message'] = $model->getErrors();
        return $info;
    }

    public function getRemainingTime($user_id)
    {
        $remaining_time = 0;
        $order = self::find()->where([
            'user_id' => $user_id,
            'status' => self::STATUS_VALID,
            'payment_status' => self::PAYMENT_STATUS_PAID,
        ])->orderBy('expired_at DESC')->one();
        if ($order && $order->expired_at > time()) {
            $remaining_time = $order->expired_at-time();
        }
        return $remaining_time;
    }

}
