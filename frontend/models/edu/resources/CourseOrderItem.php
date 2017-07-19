<?php

namespace frontend\models\edu\resources;

use Yii;
use yii\helpers\ArrayHelper;
use frontend\models\base\CourseOrderItem as BaseCourseOrderItem;
use frontend\models\base\Courseware;

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
                  [['courseware_id','coupon_type',],'integer'],
                  [['payment_id'],'string'],
                  [['order_sn'], 'string', 'max' => 32],
                  [['order_sn'], 'unique'],
             ]
        );
    }

    /**
     * [processCourseOrder 处理订单]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function processCourseOrder($params)
    {
        $info = [];
        $params['user_id']  = Yii::$app->user->identity->id;
        $params['order_sn'] = $this->builderNumber();

        // 订单数据验证
        $validate = $this->validateOrderParams($params);
        if(isset($validate['errno']) && $validate['errno'] !== 0){
            return $validate;
        }

        // 创建订单
        $info = $this->createOrderOne($validate);

        return $info;
    }

    /**
     * [validateOrderParams 验证订单数据]
     * @param  [type] $params [description]
     * @return [type]         [description]
     */
    public function validateOrderParams($params)
    {
        $info = [
            'errno'   => 0,
            'message' => ''
        ];

        // 验证课件ID
        if (!isset($params['courseware_id']) || empty($params['courseware_id'])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Courseware ID Can Not Be Null!';
            return $info;
        }

        // 验证订单状态
        if (!isset($params['status']) || !in_array($params['status'],[self::STATUS_VALID])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Order Status Is Not Legal!';
            return $info;
        }

        // 验证支付方式
        if (!isset($params['payment']) || !in_array($params['payment'],[self::PAYMENT_ONLINE,self::PAYMENT_ALIPAY,self::PAYMENT_WECHAT, self::PAYMENT_OFFLINE])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Payment Type Is Not Legal!';
            return $info;
        }else{
            $params['payment'] = (int) $params['payment'];
        }

        // 验证支付状态
        if (!isset($params['payment_status']) || empty($params['payment_status'])) {
            $params['payment_status'] = CourseOrderItem::PAYMENT_STATUS_NON_PAID;
        }

        // 验证订单总价和总课程数，待完善
        if (isset($params['total_price']) && !empty($params['total_price'])) {
            $courseware = Courseware::findOne($params['courseware_id']);
            if ($courseware && $courseware->isMasterCourseware()) {
                if ($courseware->present_price === null) {
                    $info['errno']   = __LINE__;
                    $info['message'] = 'Course Price Data Exception! Please Contact Administrator.';
                    return $info; 
                }

                // 未验证会员价等
                $params['total_price']  = $courseware->present_price;
                $params['total_course'] = $courseware->isMasterCourseware();
            }else{
                $info['errno']   = __LINE__;
                $info['message'] = 'A (master)Courseware With ID '.$params['courseware_id'].' Does Not Exist!';
                return $info; 
            }
        }else{
            $info['errno']   = __LINE__;
            $info['message'] = 'Total Price Can Not Be Null!';
            return $info;
        }

        // 验证总课程数
        if (!isset($params['presented_course']) && empty($params['presented_course'])) {
            $params['presented_course'] = '0';
        }

        // 验证优惠类型和优惠价格
        if (isset($params['coupon_type']) && !empty($params['coupon_type']) && isset($params['coupon_price']) && !empty($params['coupon_price'])) {
            if ($params['total_price'] != $params['coupon_price']+$params['real_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = 'Coupon Price Is Not Legal!';
                return $info;
            }
        }else{
            $params['coupon_price'] = 0;
        }

        // 验证实际付款，待完善
        if (isset($params['real_price']) && !empty($params['real_price'])) {
            if ($params['real_price'] != $params['total_price'] - $params['coupon_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = 'Real Price Is Not Legal!';
                return $info;
            }
        }else{
            $info['errno']   = __LINE__;
            $info['message'] = 'Real Price Can Not Be Null!';
            return $info;
        }

        // 验证订单编号
        if (!isset($params['order_sn']) || empty($params['order_sn'])) {
            $info['errno']   = __LINE__;
            $info['message'] = 'Order Sn Can Not Be Null!';
            return $info;
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
        $data['CourseOrderItem'] = $params;

        if ($model->load($data) && $model->save($data)) {
            return $model;
        }

        $info['errno']   = __LINE__;
        $info['message'] = $model->getErrors();
        return $info;
    }

    /**
     * [discountRules 用户是否满足优惠规则]
     * @return [type] [description]
     */
    public function discountRules()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        // 首单减免
        $order_count = self::find()->where([
            'user_id' => Yii::$app->user->identity->id,
            'status'  => self::STATUS_VALID,
        ])->count();
        if ($order_count == 0) {
            return true;
        }

        return false;
    }
}
