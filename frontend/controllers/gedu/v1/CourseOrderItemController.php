<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;

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
     *     description="返回课件订单内容",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_id",
     *        description = "课件ID",
     *        required = true,
     *        type = "integer"
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
     *        required = false,
     *        type = "integer",
     *        default = 110,
     *        enum = {100,110,111,200}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "total_price",
     *        description = "总价",
     *        required = false,
     *        type = "integer"
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
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回课件订单内容"
     *     )
     * )
     *
    **/
    public function actionCreate()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        if (NULL == Yii::$app->request->post()) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '参数不能为空';
            return [];
        }
        
        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        return $order->processCourseOrder(Yii::$app->request->post());
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
        $data          = [];
        $alipay_config = Yii::$app->params['payment']['gedu']['alipay'];
var_dump($alipay_config);exit;
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

        $body              = '《如来神掌(精装)》全集(共15节课程)，限时特价0.01元';
        $subject           = '《如来神掌(精装)》全集(共15节课程)';
        $out_trade_no      = $order->builderNumber();
        $total_amount      = '0.01';
        $timeout_express   = '1m';
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder;
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new AlipayTradeService($alipay_config);
        $result = $payResponse->wapPay($payRequestBuilder,$alipay_config['return_url'],$alipay_config['notify_url']);
        $data = ['wappay' => $result];
        return $data;
    }
}