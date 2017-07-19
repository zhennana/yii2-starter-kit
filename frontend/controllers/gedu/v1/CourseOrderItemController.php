<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;
use frontend\models\edu\resources\Courseware;

class CourseOrderItemController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\edu\resources\CourseOrderItem';

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
     * @SWG\Post(path="/course-order-item/create",
     *     tags={"GEDU-CourseOrderItem-课件订单接口"},
     *     summary="课件订单创建",
     *     description="成功，返回支付宝from表单",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_id",
     *        description = "课件ID",
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
     *        description = "支付方式：100在线支付；110支付宝；111微信支付；200货到付款",
     *        required = true,
     *        type = "integer",
     *        default = 110,
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
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回支付宝form表单，失败返回具体信息"
     *     )
     * )
     *
    **/
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
     * @SWG\Post(path="/course-order-item/alipay",
     *     tags={"GEDU-CourseOrderItem-课件订单接口"},
     *     summary="支付宝支付接口",
     *     description="返回请求支付宝form表单",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_order_item_id",
     *        description = "课程订单_id",
     *        required = false,
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
        if (!isset($_POST) || empty($_POST)) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '调试错误，请回到请求来源地，重新发起请求。';
            return [];
        }
        $data          = [];
        $alipay_config = Yii::$app->params['payment']['gedu']['alipay'];
        $body          = '【光大】精品课程';
        $subject       = '【光大】精品课程';

        if (!file_exists($alipay_config['merchant_private_key']) || !file_exists($alipay_config['alipay_public_key'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '秘钥或公钥不存在';
            return [];
        }

        $alipay_config['merchant_private_key'] = file_get_contents($alipay_config['merchant_private_key']);
        $alipay_config['alipay_public_key']    = file_get_contents($alipay_config['alipay_public_key']);

        $modelClass    = $this->modelClass;
        $order         = $modelClass::findOne(Yii::$app->request->post('course_order_item_id'));
        if (!$order) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '该订单不存在';
            return [];
        }

        $validate = $order->validateOrderParams($order->attributes);
        if (isset($validate['errno']) && $validate['errno'] != 0) {
            $this->serializer['errno']   = $validate['errno'];
            $this->serializer['message'] = $validate['message'];
            return [];
        }

        $courseware = Courseware::findOne($this->courseware_id);
        if ($courseware) {
            $body    = '【光大】'.$courseware->title.'(共'.$courseware->isMasterCourseware().'节课程)';
            $subject = '【光大】'.$courseware->title;
        }

        $out_trade_no    = $order->order_sn;
        $total_amount    = $order->real_price;
        $timeout_express = '1m';
        // $seller_id       = '';   // 支付宝账号对应的支付宝唯一用户号

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder;
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        // $payRequestBuilder->setSellerId($seller_id);

        $payResponse = new AlipayTradeService($alipay_config);
        $result = $payResponse->wapPay($payRequestBuilder,$alipay_config['return_url'],$alipay_config['notify_url']);
        $data = ['wappay' => $result];
        return $data;
    }
}