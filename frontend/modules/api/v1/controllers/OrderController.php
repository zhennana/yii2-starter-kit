<?php
namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\web\Response;

use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;

use common\models\User;

use frontend\models\gedu\resources\Courseware;

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
     *     summary="课程订单创建",
     *     description="成功，返回支付宝from表单",
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
     *        description = "过期时间，1=1秒，默认一个月2592000秒",
     *        required = true,
     *        type = "integer",
     *        default = "2592000"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "payment",
     *        description = "支付方式：100在线支付；110支付宝；111微信支付；115苹果商店内购支付；116苹果支付；200货到付款",
     *        required = true,
     *        type = "integer",
     *        default = 115,
     *        enum = {100,110,111,115,116,200}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "订单状态 10有效；20无效",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum = {10,20}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "total_price",
     *        description = "总价",
     *        required = true,
     *        type = "integer"
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
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "real_price",
     *        description = "实际付款",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "data",
     *        description = "支付返回的序列化数据，json格式",
     *        required = true,
     *        type = "integer",
     *        default = "Receipt data"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回支付宝form表单，失败返回具体信息"
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
        $message['message'] = Yii::t('frontend','创建成功');;
        $message['order'] = [
            'course_order_item_id' => $model->course_order_item_id,
            'user_id' => $model->user_id,
            'total_price' => $model->total_price,
            'expired_at' => $model->expired_at,
        ];
        return $message;
        // if (is_object($model)) {
        //     $from = $model->wapAlipay();
        // }

        // if (isset($from['errno']) && $from['errno'] != 0) {
        //     $this->serializer['errno']   = $from['errno'];
        //     $this->serializer['message'] = $from['message'];
        //     return [];
        // }
        // $from = ['wappay' => $from];
        // return $model;
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
            ->one();

        if (!$order) {
            $message['errorno'] = 0;
            $message['message'] = Yii::t('frontend','暂无订单');
            $message['order']   = [];
            return $message;
        }

        $message['errorno'] = 0;
        $message['message'] = Yii::t('frontend','查询成功');;
        $message['order'] = [
            'course_order_item_id' => $order->course_order_item_id,
            'user_id' => $order->user_id,
            'total_price' => $order->total_price,
            'expired_at' => $order->expired_at,
        ];
        return $message;

    }

    /**
     * @SWG\Post(path="/order/alipay",
     *     tags={"600-Order-课程订单接口"},
     *     summary="支付宝支付接口[未配置]",
     *     description="返回请求支付宝form表单",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_order_item_id",
     *        description = "课程订单_id",
     *        required = true,
     *        default = 1,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回请求支付宝form表单"
     *     )
     * )
     */
    public function actionAlipay()
    {
        return 'alipay未配置';

        if (!isset($_POST['course_order_item_id']) || empty($_POST['course_order_item_id'])) {
            $message['errorno']   = __LINE__;
            $message['message'] = 'Order ID Can Not Be Null!';
            return [];
        }

        $modelClass = $this->modelClass;
        $model      = $modelClass::findOne($_POST['course_order_item_id']);

        if (!$model) {
            $message['errorno']   = __LINE__;
            $message['message'] = 'A Order With ID '.$_POST['course_order_item_id'].' Does Not Exist!';
            return [];
        }

        // 验证订单数据
        $validate = $model->validateAppleOrder($model->attributes);
        if (isset($validate['errno']) && $validate['errno'] != 0) {
            $message['errorno']   = $validate['errno'];
            $message['message'] = $validate['message'];
            return [];
        }

        return $validate;
        /*
        // 调用支付宝支付方法
        $from = $model->wapAlipay();
        if (isset($from['errno']) && $from['errno'] != 0) {
            $message['errorno']   = $from['errno'];
            $message['message'] = $from['message'];
            return [];
        }

        $message['errorno'] = 0;
        $message['message'] = Yii::t('frontend','查询成功');;
        $message['order'] = ['wappay' => $from];
        return $message;
        */
    }

    /**
     * @SWG\Post(path="/order/activation-code",
     *     tags={"600-Order-课程订单接口"},
     *     summary="激活码激活",
     *     description="提交用户ID与激活码做验证",
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
     *        description = "激活码",
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
        // 查询激活码，状态未使用
        // 创建订单，返回course_order_item_id，存入表activation_code对应字段
        // errorno = 1 已经使用
        $info = [
            'errorno' => '0',
            'message' => '',
        ];
        $post = Yii::$app->request->post();

        if (!isset($post['user_id']) && empty($post['user_id'])) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','请输入user id');
            return $info;
        }
        if (!isset($post['activation_code']) && empty($post['activation_code'])) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','请输入激活码');
            return $info;
        }
        // 校验用户
        $user = User::find()->where(['id' => $post['user_id']])->active()->one();
        if (!$user) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','该用户不存在');
            return $info;
        }

        // 校验激活码
        $codeModel = ActivationCode::checkCode($post['activation_code']);

        if (!$codeModel) {
            $info['errorno'] = __LINE__;
            $info['message'] = Yii::t('frontend','无效的激活码');
            return $info;
        }

        // 创建订单
        $order = new CourseOrderItem;
        $order = $order->createActivationOrder($codeModel,$post);
        if ($order['errorno'] != '0' && $order['model'] == null) {
            $info['errorno'] = $order['errorno'];
            $info['message'] = $order['message'];
            return $info;
        }
        // 更新激活码
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
}