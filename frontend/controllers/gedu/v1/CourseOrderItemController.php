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
     *         description = "返回课件订单内容"
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

        $info = [];

        $modelClass = $this->modelClass;
        $order      = new $modelClass;

        $info = $order->processCourseOrder(Yii::$app->request->post());

        if (isset($info['errno']) && $info['errno'] !== 0) {
            $this->serializer['errno']   = $info['errno'];
            $this->serializer['message'] = $info['message'];
            return [];
        }

        return $info;
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
/*
        if (!file_exists($alipay_config['merchant_private_key']) || !file_exists($alipay_config['alipay_public_key'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '秘钥或公钥不存在';
            return [];
        }

        $alipay_config['merchant_private_key'] = file_get_contents($alipay_config['merchant_private_key']);
        $alipay_config['alipay_public_key']    = file_get_contents($alipay_config['alipay_public_key']);
*/
        $alipay_config['merchant_private_key'] = 'MIIEowIBAAKCAQEAyZkDYyz5ah4AYdpmNXR/CTsVdIgWrEKHr4FKpNseKMaylYtFYgk5gwLqhlciA+RGlZtGi249snqqQab2PcZ4Tiz4/zOr1RUCeTf6W6Ivr5AR2V6EcrKACclaWNoUGGC66rbsODdSfJci9H69qIQW272rH+KvvJ1rOpOa5WLmBvJ9HtExgSaGCZLMJiQHQRvVyVE9uchULQJBFdspCI8DzuqagAcfxyRBfSYJsiS+nFU7UtKLIbCX4rRKlhe+uv9DjrR01b/7eXKzdTX+f5ns9/c+5wFjfxWQgs3dDJ0pF5HUv6XyEtitiFkkYNzsOE77m2A5rE2EtJ0ETXBkMCIZJQIDAQABAoIBAGSmUFqjiaLBd89jCsSFdSdWqE+V4jv+u1+UXYARJe2VxnODJRDdKimOuyh3ODRZNCRdccsLLyJ8u6Qrh6UwAcCGE4rWcWPhKWr717MINmagt0ifN+FL3UEFlmXl+0JwiOHGkgk/FZ++lWUcIfSQfhkXiOhSdQrmTTLhnuQHjHDKnS46YQVxmV6nWBG0lGje++5MtBExj5W22iu6759LA+kD1quu1xwnntlQoh2BUk5AB8PqnrgQoOGI2MZzPS6Spy3fAv+DeyUPw/jk09tKPLl7xvWDJtpHaEW2OM+T+enAHSqJEo8nsy65hXqtbHKHBtgEGe4EILSB/hHJsWhZegECgYEA7rUdbjjf1zG34sOKUW0P2Llb7fG1xeglD95iZpXcXn/0rskcA2e6RynwTUysfNEzSNhNZqn9FWyEzYcvSlSRlYY7g3zL0EtSIDaY4MsM7iW25UXBh2W5murSN5aSDvHNlcgugbnhfPnYB16qtQqN2qpniIN0avUbofyBbGx+upkCgYEA2DOwY4S4G8AwnBOCwP1UrrgDEDRv77rckTZOG7+6QcGRZqX5vEViwZwSGCubr3UdBJlr9cDQO1cwaMi2GkD/+WOuw8rR6QQ7Cxo94H1cHHXsuWKUIvkTVUGeRWZrq2DGUelFo3uvsRHY9Yr/tf1oDMtUr8QXM5ftJZKYEMjvlm0CgYEAtlTbbRS+TbZpWim4Xmfq4cT75i1phgjDPnLEQM2ZbQlZ0aRF5If3rmHnbnPxkMmO3cZyoMeZTCL+8aqfwawFI+xLSy0o1SqjSX3KmnIep01hfZEhuRVHh4B0IAe/+vBR82XbuDVOelKw4zg5Nl4ganUc7hZS91vPxpSEG1hoGIkCgYAGvV3DTHDc1JnvU6Bg2cTZCX129NuEcqPLlxDKRqjMwfcBZy0o1FTmyjG6NSnOR21XJl06NP+IyggFTDR5Dwurv5LEIb93bx1UFEZXiDDl5jsx8EPD71XN85S2fyHeHs8v4IC+Pu3ULEVCKkocZ0DmHTSPoiJDBnprEG3TICBv5QKBgHn3ExoTO/1E4bGt8nZ0pxA05amHM368wxjcYL3zIB4Q/nO5uTyfLT3Im31fhJWr/TkQAIdUvA/G5/0UK+SUgBX+ngCaI0bDm59199H58NJN1Pm94xvsktogYBSpz6TxBp0bqF/IWcbJmW59I/HlZFusNmN79c+nG83Yq1ZRKrMl';
        $alipay_config['alipay_public_key'] = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB';

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

        $body            = '《如来神掌(精装)》全集(共15节课程)，限时特价0.01元';
        $subject         = '《如来神掌(精装)》全集(共15节课程)';
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