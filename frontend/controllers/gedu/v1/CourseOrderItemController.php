<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;

use common\payment\alipay\buildermodel\AlipayTradeWapPayContentBuilder;
use common\payment\alipay\AlipayTradeService;

use frontend\models\gedu\resources\Courseware;

class CourseOrderItemController extends \common\rest\Controller
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
     * @SWG\Post(path="/course-order-item/create",
     *     tags={"GEDU-CourseOrderItem-课程订单接口"},
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
     *        name = "payment",
     *        description = "支付方式：100在线支付；110支付宝；111微信支付；200货到付款",
     *        required = true,
     *        type = "integer",
     *        default = 110,
     *        enum = {100,110,111,200}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "present_price",
     *        description = "现价",
     *        required = true,
     *        type = "integer",
     *        default = 47
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

        $data = [];

        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        $model = $order->processCourseOrder(Yii::$app->request->post());
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
            $data = $model->wapAlipay();
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
     * @SWG\Post(path="/course-order-item/alipay",
     *     tags={"GEDU-CourseOrderItem-课程订单接口"},
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