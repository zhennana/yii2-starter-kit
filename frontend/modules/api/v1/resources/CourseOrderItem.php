<?php

namespace frontend\modules\api\v1\resources;

use Yii;
use cheatsheet\Time;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\payment\alipay\AopClient;
use common\payment\alipay\request\AlipayTradeAppPayRequest;
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
                [['expired_at','days'],'integer'],
                ['days','required'],
             ]
        );
    }

    /**
     *  [createActivationOrder 创建兑换码订单]
     *  @param  [type] $codeModel [description]
     *  @param  [type] $params    [description]
     *  @return [type]            [description]
     */
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
            $info['message'] = Yii::t('frontend','无效的兑换码');
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
        $model->days           = 372;   // 31*12
        $model->expired_at     = $this->getRemainingTime($params['user_id'],372);
        if (!$model->save()) {
            $info['errorno'] = __LINE__;
            $info['message'] = $model->getErrors();
            return $info;
        }

        $info['model'] = $model;
        return $info;
    }

    /**
     *  [processAppleOrder 处理苹果内购订单]
     *  @return [type] [description]
     */
    public function processAppleOrder()
    {
        $info = [];
        $params = Yii::$app->request->post();

        $params['user_id']  = Yii::$app->user->identity->id;
        $params['order_sn'] = $this->builderNumber();

        // 验证数据
        $validate = $this->validateAppleOrder($params);
        if(isset($validate['errno']) && $validate['errno'] !== 0){
            return $validate;
        }

        // 创建订单
        $info = $this->createOrderOne($validate);
        return $info;
    }

    /**
     *  [processOrderV2 订单处理V2]
     *  @return [type] [description]
     */
    public function processOrderV2()
    {
        $info = [];

        $params = Yii::$app->request->post();
        $params['user_id']        = Yii::$app->user->identity->id;
        $params['order_sn']       = $this->builderNumber();
        $params['status']         = self::STATUS_VALID;
        $params['total_course']   = 0;

        // 验证数据
        $validate = $this->validateOrderV2($params);

        if (isset($validate['errno'])&& $validate['errno'] !== 0) {
            return $validate;
        }
// var_dump($validate);exit;
        $info = $this->createOrderOne($validate);
        return $info;
    }

    /**
     *  [validateAppleOrder 验证苹果内购订单数据]
     *  @param  [type] $params [description]
     *  @return [type]         [description]
     */
    public function validateAppleOrder($params)
    {
        $info = [
            'errno'   => 0,
            'message' => ''
        ];

        if (!isset($params['school_id']) || empty($params['school_id']) || $params['school_id'] != 3) {
            $params['school_id'] = 3;
        }

        // 验证过期时间
        if (!isset($params['expired_at']) || empty($params['expired_at'])) {
            $info['errno']   = __LINE__;
            $info['message'] = '延长时间不能为空!';
            return $info;
        }

        // 临时更改字段
        $params['days'] = $params['expired_at'];

        // 获取过期时间
        $params['expired_at'] = $this->getRemainingTime($params['user_id'],$params['days']);

        // 验证订单状态
        if (!isset($params['status']) || !in_array($params['status'],[self::STATUS_VALID])) {
            $info['errno']   = __LINE__;
            $info['message'] = '订单状态不合法!';
            return $info;
        }

        // 验证支付方式
        if (!isset($params['payment']) || !in_array($params['payment'],[self::PAYMENT_ONLINE,self::PAYMENT_ALIPAY,self::PAYMENT_WECHAT, self::PAYMENT_OFFLINE, self::PAYMENT_APPLEPAY, self::PAYMENT_APPLEPAY_INAPP])) {
            $info['errno']   = __LINE__;
            $info['message'] = '支付方式不合法!';
            return $info;
        }else{
            $params['payment'] = (int) $params['payment'];
        }

        // 验证优惠类型和优惠价格
        if (isset($params['coupon_type']) && !empty($params['coupon_type'])) {
            if (isset($params['coupon_price']) && !empty($params['coupon_price'])) {
                if ($params['coupon_price'] != $params['total_price']-$params['real_price']) {
                    $info['errno']   = __LINE__;
                    $info['message'] = '优惠价格不合法!';
                    return $info;
                }
            }
        }else{
            $params['coupon_type']  = null;
            $params['coupon_price'] = 0;
        }

        if (!isset($params['coupon_price']) || empty($params['coupon_price'])) {
            $params['coupon_type']  = null;
            $params['coupon_price'] = 0;
        }

        // 验证实际付款
        if (isset($params['real_price']) && !empty($params['real_price'])) {
            if ($params['coupon_price'] >= $params['real_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = '优惠价格不能大于实付款!';
                return $info;
            }
            if ($params['real_price'] != $params['total_price'] - $params['coupon_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = '实付款不合法!';
                return $info;
            }
        }else{
            $info['errno']   = __LINE__;
            $info['message'] = '实付款不能为0!';
            return $info;
        }

        if (!isset($params['total_course']) || empty($params['total_course'])) {
            $params['total_course'] = 0;
        }

        // 苹果内购验证
        if (!isset($params['data']) || empty($params['data'])) {
            $info['errno']   = __LINE__;
            $info['message'] = '票据不能为空!';
            return $info;
        }
        if ($params['payment'] == self::PAYMENT_APPLEPAY_INAPP) {
            $params['payment_status'] = self::PAYMENT_STATUS_PAID_CLIENT;
        }
        if ($info['errno'] == 0) {
            return $params;
        }

        return $info;
    }

    /**
     *  [validateOrderV2 订单验证与组装V2]
     *  @param  [type] $data [description]
     *  @return [type]       [description]
     */
    public function validateOrderV2($data)
    {
        $info = [
            'errno'   => 0,
            'message' => ''
        ];

        if (!isset($data['school_id']) || empty($data['school_id']) || $data['school_id'] != 3) {
            $data['school_id'] = 3;
        }

        // 验证订单状态
        if (!isset($data['status']) || !in_array($data['status'],[self::STATUS_VALID])) {
            $info['errno']   = __LINE__;
            $info['message'] = '订单状态不合法!';
            return $info;
        }

        // 验证支付方式
        if (!isset($data['payment']) || !in_array($data['payment'],[self::PAYMENT_ONLINE,self::PAYMENT_ALIPAY,self::PAYMENT_WECHAT, self::PAYMENT_OFFLINE, self::PAYMENT_APPLEPAY_INAPP])) {
            $info['errno']   = __LINE__;
            $info['message'] = '支付方式不合法!';
            return $info;
        }else{
            $data['payment'] = (int) $data['payment'];
        }

        // 苹果内购验证
        if ($data['payment'] == self::PAYMENT_APPLEPAY_INAPP) {
            if (!isset($data['data']) || empty($data['data'])) {
                $info['errno']   = __LINE__;
                $info['message'] = '票据不能为空!';
                return $info;
            }
            $data['payment_status'] = self::PAYMENT_STATUS_PAID_CLIENT;
        }else{
            $data['payment_status'] = self::PAYMENT_STATUS_NON_PAID;
        }

        // 验证优惠类型和优惠价格
        if (isset($data['coupon_type']) && !empty($data['coupon_type'])) {
            if (isset($data['coupon_price']) && !empty($data['coupon_price'])) {
                if ($data['coupon_price'] != $data['total_price']-$data['real_price']) {
                    $info['errno']   = __LINE__;
                    $info['message'] = '优惠价格不合法!';
                    return $info;
                }
            }
        }else{
            $data['coupon_type']  = null;
            $data['coupon_price'] = 0;
        }
        if (!isset($data['coupon_price']) || empty($data['coupon_price'])) {
            $data['coupon_type']  = null;
            $data['coupon_price'] = 0;
        }


        // 验证延长卡类型
        if (isset($data['card_type']) && !empty($data['card_type'])) {
            if (isset(Yii::$app->params['shuo']['card_type'][$data['card_type']])) {
                $card_type = Yii::$app->params['shuo']['card_type'][$data['card_type']];
            }else{
                $info['errno']   = __LINE__;
                $info['message'] = '延长卡类型不合法!';
                return $info;
            }
        }else{
            $info['errno']   = __LINE__;
            $info['message'] = '延长卡类型不能为空!';
            return $info;
        }

        // 延长卡类型计入data
        if ($data['payment'] != self::PAYMENT_APPLEPAY_INAPP) {
            $data['data'] = $data['card_type'];
        }

        // 验证实际付款
        if (isset($data['real_price']) && !empty($data['real_price'])) {
            if ($data['coupon_price'] >= $data['real_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = '优惠价格不能大于实付款!';
                return $info;
            }
            if ($data['real_price'] != $card_type['price']) {
                $info['errno']   = __LINE__;
                $info['message'] = '实付款不合法!';
                return $info;
            }

            // 验证总价
            if ($data['real_price'] != $data['total_price']-$data['coupon_price']) {
                $info['errno']   = __LINE__;
                $info['message'] = '总价不合法!';
                return $info;
            }
        }else{
            $info['errno']   = __LINE__;
            $info['message'] = '实付款不能为0!';
            return $info;
        }

        // 验证并转换过期时间
        if (isset($data['days']) && !empty($data['days'])) {
            if ($data['days'] != $card_type['time']) {
                $info['errno']   = __LINE__;
                $info['message'] = '续费时间不合法!';
                return $info;
            }
        }else{
            $data['days'] = $card_type['time'];
        }

        // 苹果计算过期时间
        if ($data['payment'] == self::PAYMENT_APPLEPAY_INAPP) {
            $data['expired_at'] = $this->getRemainingTime($data['user_id'], $data['days']);
        }


        if ($info['errno'] == 0) {
            return $data;
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

    /**
     *  [appAlipay 支付宝APP支付]
     *  @return [type] [description]
     */
    public function appAlipay()
    {
        $result        = [];
        $alipay_config = Yii::$app->params['payment']['shuo']['alipay'];
        $body          = '【说说说科技】';
        $subject       = '【说说说科技】';

        // 检测密钥公钥
        if (!file_exists($alipay_config['merchant_private_key']) || !file_exists($alipay_config['alipay_public_key'])) {
            $result['errno']    = __LINE__;
            $result['message'] = '密钥不存在';
            return $result;
        }
        $alipay_config['merchant_private_key'] = file_get_contents($alipay_config['merchant_private_key']);
        $alipay_config['alipay_public_key']    = file_get_contents($alipay_config['alipay_public_key']);

        // 组装业务参数
        if (isset(Yii::$app->params['shuo']['card_type'][$this->data])) {
            $subject .= Yii::$app->params['shuo']['card_type'][$this->data]['card_name'];
            $subject .= '('.Yii::$app->params['shuo']['card_type'][$this->data]['time'];
            $subject .= '天)';
        }

        $aop = new AopClient;
        $aop->gatewayUrl         = $alipay_config['gatewayUrl'];
        $aop->appId              = $alipay_config['app_id'];
        $aop->rsaPrivateKey      = $alipay_config['merchant_private_key'];
        $aop->format             = $alipay_config['format'];
        $aop->charset            = $alipay_config['charset'];
        $aop->signType           = $alipay_config['sign_type'];
        $aop->alipayrsaPublicKey = $alipay_config['alipay_public_key'];

        $request = new AlipayTradeAppPayRequest();

        // 业务参数
        $content = [
            'body'            => $body, // 非必填
            'subject'         => $subject,
            'out_trade_no'    => $this->order_sn,
            'timeout_express' => $alipay_config['timeout_express'], // 非必填
            'total_amount'    => $this->real_price,
            'product_code'    => $alipay_config['product_code'],
        ];
        $bizcontent = json_encode($content);

        $request->setNotifyUrl($alipay_config['notify_url']);
        $request->setBizContent($bizcontent);

        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);

        //防止被浏览器将关键参数html转义
        return htmlspecialchars($response);
    }

    /**
     *  [getRemainingTime 获取过期时间]
     *  @param  [type] $user_id [description]
     *  @return [type]          [description]
     */
    public function getRemainingTime($user_id, $days=0)
    {
        $time = time();
        $expired_at = $time+$days*Time::SECONDS_IN_A_DAY;
        $order = self::find()->where([
            'user_id'        => $user_id,
            'status'         => self::STATUS_VALID,
            'payment_status' => [self::PAYMENT_STATUS_PAID,self::PAYMENT_STATUS_PAID_CLIENT],
        ])->orderBy('expired_at DESC')->one();

        if ($order && $order->expired_at > $time) {
            $expired_at = $order->expired_at+$days*Time::SECONDS_IN_A_DAY;
        }
        return $expired_at;
    }

}
