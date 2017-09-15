<?php
namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\web\Response;

use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;

use frontend\models\gedu\resources\Courseware;

class OrderController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\gedu\resources\CourseOrderItem';

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
     *        name = "course_id",
     *        description = "课程ID",
     *        required = true,
     *        type = "integer",
     *        default = 1
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校ID",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "grade_id",
     *        description = "班级ID",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "introducer_id",
     *        description = "介绍人ID",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "total_course",
     *        description = "课程的总数",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "presented_course",
     *        description = "赠送的课程数量",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "payment",
     *        description = "支付方式：100在线支付；110支付宝；111微信支付；115苹果商店内购支付；116苹果支付；200货到付款",
     *        required = true,
     *        type = "integer",
     *        default = 113,
     *        enum = {100,110,111,200}
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
     *        type = "integer",
     *        default = 47
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
     *        type = "integer",
     *        default = 37
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
     */
    public function actionCreate()
    {
        // return [];exit();
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $from = [];

        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        $model = $order->processCourseOrder(Yii::$app->request->post());

        if (isset($model['errno']) && $model['errno'] !== 0) {
            $this->serializer['errno']   = $model['errno'];
            $this->serializer['message'] = $model['message'];
            return [];
        }

        if (is_object($model)) {
            $from = $model->wapAlipay();
        }

        if (isset($from['errno']) && $from['errno'] != 0) {
            $this->serializer['errno']   = $from['errno'];
            $this->serializer['message'] = $from['message'];
            return [];
        }
        $from = ['wappay' => $from];
        return $from;
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
        $order = CourseOrderItem::find()
            ->where([
                'user_id'        => Yii::$app->user->identity->id,
                'status'         => CourseOrderItem::STATUS_VALID,
                'payment_status' => CourseOrderItem::PAYMENT_STATUS_PAID,
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
     *     summary="支付宝支付接口",
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
        if (!isset($_POST['course_order_item_id']) || empty($_POST['course_order_item_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'Order ID Can Not Be Null!';
            return [];
        }

        $modelClass = $this->modelClass;
        $model      = $modelClass::findOne($_POST['course_order_item_id']);

        if (!$model) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'A Order With ID '.$_POST['course_order_item_id'].' Does Not Exist!';
            return [];
        }

        // 验证订单数据
        $validate = $model->validateOrderParams($model->attributes);
        if (isset($validate['errno']) && $validate['errno'] != 0) {
            $this->serializer['errno']   = $validate['errno'];
            $this->serializer['message'] = $validate['message'];
            return [];
        }

        // 调用支付宝支付方法
        $from = $model->wapAlipay();
        if (isset($from['errno']) && $from['errno'] != 0) {
            $this->serializer['errno']   = $from['errno'];
            $this->serializer['message'] = $from['message'];
            return [];
        }
        $from = ['wappay' => $from];
        return $from;
    }
}