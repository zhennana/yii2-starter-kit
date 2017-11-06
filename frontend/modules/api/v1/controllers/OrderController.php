<?php
namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\web\Response;
use cheatsheet\Time;
use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;

use common\models\User;

use frontend\modules\api\v1\resources\ActivationCode;

class OrderController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\CourseOrderItem';

    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        // 'errno' => 0,                           // 错误处理数字
        'message' => 'OK',                      // 文本提示
    ];

    /**
     * @param  [action] yii\rest\IndexAction
     * @return [type] 
     */
    public function beforeAction($action)
    {
        $format = \Yii::$app->getRequest()->getQueryParam('format', 'json');

        if($format == 'xml'){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        // 移除access行为，参数为空全部移除
        // Yii::$app->controller->detachBehavior('access');
        return $action;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function afterAction($action, $result){
        $result = parent::afterAction($action, $result);

        return $result;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }

    /**
     * @SWG\Post(path="/order/create",
     *     tags={"600-Order-课程订单接口"},
     *     summary="APPLE内购订单创建[待删除，请更换为create v2]",
     *     description="成功，返回订单数据",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校ID",
     *        required = true,
     *        type = "integer",
     *        default = 3
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "expired_at",
     *        description = "[days临时改为expired_at]延长时间，单位：天",
     *        required = true,
     *        type = "integer",
     *        default = "1"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "payment",
     *        description = "115苹果商店内购支付",
     *        required = true,
     *        type = "integer",
     *        default = 115,
     *        enum = {115}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "订单状态 10有效",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum = {10}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "total_price",
     *        description = "总价",
     *        required = true,
     *        type = "number"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "coupon_type",
     *        description = "优惠类型 2首单减免；3随机减免",
     *        required = false,
     *        type = "integer",
     *        enum = {2,3}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "coupon_price",
     *        description = "优惠金额",
     *        required = false,
     *        type = "number"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "real_price",
     *        description = "实际付款",
     *        required = true,
     *        type = "number"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "data",
     *        description = "支付返回的序列化数据，json格式",
     *        required = true,
     *        type = "string",
     *        default = "Receipt data"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回订单信息，失败返回具体信息"
     *     )
     * )
     *
    **/
    /**
整个支付流程如下：
1.客户端向Appstore请求购买产品（假设产品信息已经取得），Appstore验证产品成功后，从用户的Apple账户余额中扣费。
2.Appstore向客户端返回一段receipt-data，里面记录了本次交易的证书和签名信息。
3.客户端向我们可以信任的游戏服务器提供receipt-data
4.游戏服务器对receipt-data进行一次base64编码
5.把编码后的receipt-data发往itunes.appstore进行验证
6.itunes.appstore返回验证结果给游戏服务器
7.游戏服务器对商品购买状态以及商品类型，向客户端发放相应的道具与推送数据更新通知

在sandbox中验证receipt
https://sandbox.itunes.apple.com/verifyReceipt
在生产环境中验证receipt
https://buy.itunes.apple.com/verifyReceipt

Receipt: {"Store":"fake","TransactionID":"bc0df36d-13be-4d9f-b9d1-4d980d11c402","Payload":"{ \"this\" : \"is a fake receipt\" }"}
     */
    public function actionCreate()
    {
        // return [];exit();
        if(Yii::$app->user->isGuest){
            $message['errorno'] = __LINE__;
            $message['message'] = Yii::t('frontend','请登录');
            return $message;
        }

        $from = [];

        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        $model = $order->processAppleOrder();
        if (isset($model['errno']) && $model['errno'] !== 0) {
            $message['errorno']    = $model['errno'];
            $message['message'] = $model['message'];
            return $message;
        }

        $message['errorno'] = 0;
        $message['message'] = Yii::t('frontend','创建成功');
        $message['order'] = [
            'course_order_item_id' => $model->course_order_item_id,
            'order_sn' => $model->order_sn,
            'user_id' => $model->user_id,
            'total_price' => $model->total_price,
            'expired_at' => $model->expired_at,
        ];
        return $message;
    }

    /**
     * @SWG\Post(path="/order/create-v2",
     *     tags={"600-Order-课程订单接口"},
     *     summary="订单创建",
     *     description="成功，返回订单数据",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校ID",
     *        required = true,
     *        type = "integer",
     *        default = 3
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "payment",
     *        description = "110支付宝；111微信支付；115苹果商店内购支付；200货到付款",
     *        required = true,
     *        type = "integer",
     *        default = 110,
     *        enum = {110,111,115,200}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "card_type",
     *        description = "延长卡类型:probation体验卡；month_card月卡；half_year_card半年卡；year_card年卡",
     *        required = true,
     *        type = "string",
     *        default = "probation",
     *        enum = {"probation","month_card","half_year_card","year_card"}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "total_price",
     *        description = "总价",
     *        required = true,
     *        type = "number",
     *        default = 12
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "coupon_type",
     *        description = "优惠类型 2首单减免；3随机减免",
     *        required = false,
     *        type = "integer",
     *        enum = {2,3}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "coupon_price",
     *        description = "优惠金额",
     *        required = false,
     *        type = "number"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "real_price",
     *        description = "实际付款",
     *        required = true,
     *        type = "number",
     *        default = 12
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "data",
     *        description = "苹果内购票据，json格式，支付方式为苹果内购时不能为空",
     *        required = false,
     *        type = "string",
     *        default = "Receipt data"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回订单信息，失败返回具体信息"
     *     )
     * )
     *
    **/
    public function actionCreateV2()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno'] = __LINE__;
            $this->serializer['message'] = Yii::t('frontend','请登录');
            return [];
        }
        $data = [];
        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        $model = $order->processOrderV2();
        if (isset($model['errno']) && $model['errno'] !== 0) {
            $this->serializer['errno']   = $model['errno'];
            $this->serializer['message'] = $model['message'];
            return [];
        }

        if (!is_object($model)) {
            $this->serializer['errno']   = $model['errno'];
            $this->serializer['message'] = $model['message'];
            return [];
        }

        if ($model->payment == $modelClass::PAYMENT_ALIPAY) {
            $data = $model->appAlipay();
        }elseif($model->payment == $modelClass::PAYMENT_WECHAT){
            $data = $model->appWechatpay();
        }

        if (isset($data['errno']) && $data['errno'] != 0) {
            $this->serializer['errno']   = $data['errno'];
            $this->serializer['message'] = $data['message'];
            return [];
        }

        return $data;
    }

    /**
     * @SWG\Post(path="/order/continue-pay",
     *     tags={"600-Order-课程订单接口"},
     *     summary="继续支付接口",
     *     description="适用于支付未完成后的再次支付",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_order_item_id",
     *        description = "课程订单_id",
     *        required = true,
     *        default = 1,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "payment",
     *        description = "110支付宝；111微信支付;",
     *        required = true,
     *        type = "integer",
     *        default = 110,
     *        enum = {110,111}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回请求支付宝form表单"
     *     )
     * )
     */
    public function actionContinuePay()
    {
        if (!isset($_POST['course_order_item_id']) || empty($_POST['course_order_item_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '订单ID不能为空!';
            return [];
        }
        $data = [];
        $modelClass = $this->modelClass;
        $model      = $modelClass::findOne($_POST['course_order_item_id']);
        if (!$model) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'ID为'.$_POST['course_order_item_id'].'的订单不存在!';
            return [];
        }

        // 验证订单数据
        $validate = $model->validateOrderV2($model->attributes);
        if (isset($validate['errno']) && $validate['errno'] != 0) {
            $this->serializer['errno']   = $validate['errno'];
            $this->serializer['message'] = $validate['message'];
            return [];
        }

        if ($_POST['payment'] == $modelClass::PAYMENT_ALIPAY) {
            $data = $model->appAlipay();
        }elseif($_POST['payment'] == $modelClass::PAYMENT_WECHAT){
            $data = $model->appWechatpay();
        }

        if (isset($data['errno']) && $data['errno'] != 0) {
            $this->serializer['errno']   = $data['errno'];
            $this->serializer['message'] = $data['message'];
            return [];
        }

        return $data;
    }

    /**
     * @SWG\Post(path="/order/activation-code",
     *     tags={"600-Order-课程订单接口"},
     *     summary="兑换码激活",
     *     description="提交用户ID与兑换码做验证",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "user_id",
     *        description = "用户ID，注意提交谁的激活谁的",
     *        default = "123456",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "activation_code",
     *        description = "兑换码",
     *        required = true,
     *        default = "123456",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回激活信息"
     *     )
     * )
     *
     */
    public function actionActivationCode()
    {
        // 查询兑换码，状态未使用
        // 创建订单，返回course_order_item_id，存入表activation_code对应字段
        // errorno = 1 已经使用
        $info = [
            'errorno' => '0',
            'message' => '',
        ];
        $post = Yii::$app->request->post();
        $modelClass = $this->modelClass;

        if (!isset($post['user_id']) && empty($post['user_id'])) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','请输入user id');
            return $info;
        }
        if (!isset($post['activation_code']) && empty($post['activation_code'])) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','请输入兑换码');
            return $info;
        }
        // 校验用户
        $user = User::find()->where(['id' => $post['user_id']])->active()->one();
        if (!$user) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','该用户不存在');
            return $info;
        }

        // 校验兑换码
        $codeModel = ActivationCode::checkCode($post['activation_code']);

        if (!$codeModel) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','无效的兑换码');
            return $info;
        }

        // 创建订单
        $order = new $modelClass;
        $order = $order->createActivationOrder($codeModel,$post);
        if ($order['errorno'] != '0' && $order['model'] == null) {
            $info['errorno'] = $order['errorno'];
            $info['message'] = $order['message'];
            return $info;
        }
        // 更新兑换码
        $codeModel = $codeModel->updateCode($order['model']);

        if (!$codeModel) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','数据异常');
            return $info;
        }

        return [
            'errorno' => '0',
            'message' => Yii::t(
                'frontend', 
               // 'Your account has been successfully activated.'
               '成功激活'
            )
        ];

    }

    /**
     * @SWG\Post(path="/order/share-award",
     *     tags={"600-Order-课程订单接口"},
     *     summary="创建分享奖励订单",
     *     description="提交用户ID、创建分享奖励订单，每天仅一次",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "user_id",
     *        description = "用户ID，注意提交谁的赠送给谁",
     *        default = "123456",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回激活信息"
     *     )
     * )
     *
     */
    public function actionShareAward()
    {
        $user = User::findOne(Yii::$app->request->post('user_id'));
        if (!$user) {
            $message['errorno'] = __LINE__;
            $message['message'] = Yii::t('frontend','用户不存在');
            return $message;
        }
        $modelClass = $this->modelClass;
        $share_count = $modelClass::find()
            ->where([
                'user_id' => Yii::$app->request->post('user_id'),
                'payment' => $modelClass::PAYMENT_SHAREFREE,
                'status' => $modelClass::STATUS_VALID
            ])
            ->andWhere(['>','created_at', strtotime(date("Y-m-d"),time())])
            ->count();

        if ($share_count > 0) {
            $message['errorno'] = __LINE__;
            $message['message'] = Yii::t('frontend','超过次数限制');
            return $message;
        }
        $data = [];
        $model = new $modelClass;

        $data['order_sn']       = $model->builderNumber();
        $data['school_id']      = 3;
        $data['user_id']        = Yii::$app->request->post('user_id');
        $data['payment']        = $modelClass::PAYMENT_SHAREFREE;
        $data['status']         = $modelClass::STATUS_VALID;
        $data['payment_status'] = $modelClass::PAYMENT_STATUS_PAID;
        $data['total_price']    = 0;
        $data['real_price']     = 0;
        $data['total_course']   = 0;
        $data['expired_at']     = $model->getRemainingTime(Yii::$app->request->post('user_id'),7);
        $data['days']           = 7;

        $model = $model->createOrderOne($data);

        if (isset($model['errno']) && $model['errno'] != 0) {
            $message['errorno'] = $model['errno'];
            $message['message'] = $model['message'];
            return $message;
        }
        
        return $model;
    }

    /**
     * @SWG\Get(path="/order/list",
     *     tags={"600-Order-课程订单接口"},
     *     summary="用户有效课程订单",
     *     description="返回当前登录用户的有效课程订单",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回订单信息"
     *     )
     * )
     */
    public function actionList()
    {
        //返回当前登录用户的有效订单，需要的字段，不需要的不显示
        // 用户id、价格、到期时间
        if (Yii::$app->user->isGuest) {
            $message['errorno'] = __LINE__;
            $message['message'] = Yii::t('frontend','请登录');
            return $message;
        }

        $modelClass = $this->modelClass;
        $order = $modelClass::find()
            ->where([
                'user_id'        => Yii::$app->user->identity->id,
                'status'         => $modelClass::STATUS_VALID,
                'payment_status' => $modelClass::PAYMENT_STATUS_PAID,
            ])
            ->notExpired()
            ->orderBy('expired_at DESC')
            ->one();

        if (!$order) {
            $message['errorno'] = 0;
            $message['message'] = Yii::t('frontend','暂无订单');
            $message['order']   = [];
            return $message;
        }

        $message['errorno'] = 0;
        $message['message'] = Yii::t('frontend','查询成功');
        $message['order'] = [
            'course_order_item_id' => $order->course_order_item_id,
            'order_sn' => $order->order_sn,
            'user_id' => $order->user_id,
            'total_price' => $order->total_price,
            'expired_at' => $order->expired_at,
        ];
        return $message;

    }

    /**
     * @SWG\Get(path="/order/check-expired",
     *     tags={"600-Order-课程订单接口"},
     *     summary="查询用户使用到期时间",
     *     description="返回当前登录用户的使用到期时间",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回当前登录用户的使用到期时间"
     *     )
     * )
     */
    public function actionCheckExpired()
    {
        if (Yii::$app->user->isGuest) {
            $this->serializer['errno'] = __LINE__;
            $this->serializer['message'] = Yii::t('frontend','请登录');
            return [];
        }
        $expired_at = 0;
        $data       = [];

        $modelClass = $this->modelClass;
        $order = $modelClass::find()->where([
            'user_id'        => Yii::$app->user->identity->id,
            'status'         => $modelClass::STATUS_VALID,
            'payment_status' => [$modelClass::PAYMENT_STATUS_PAID,$modelClass::PAYMENT_STATUS_PAID_SERVER],
        ])->orderBy('expired_at DESC')->one();
        if ($order) {
            $expired_at = $order->expired_at;
        }

        $this->serializer['message'] = Yii::t('frontend','查询成功');
        $data = [
            'user_id'    => Yii::$app->user->identity->id,
            'time_stamp' => $expired_at,
            'expired_at' => date('Y-m-d H:i:s',$expired_at),
        ];

        return $data;
    }
}