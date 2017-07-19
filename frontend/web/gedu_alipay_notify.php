<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
defined('VENDOR') or define('VENDOR', realpath(__DIR__.'/../../vendor'));
defined('ROOT') or define('ROOT', realpath(__DIR__.'/../../'));

require(VENDOR.'/autoload.php');

$dotenv = new \Dotenv\Dotenv(ROOT);
$dotenv->load();

defined('YII_DEBUG') or define('YII_DEBUG', getenv('YII_DEBUG') === 'true');
defined('YII_ENV') or define('YII_ENV', getenv('YII_ENV') ?: 'prod');

// Yii
require(VENDOR.'/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/base.php'),
    require(__DIR__ . '/../../common/config/web.php'),
    require(__DIR__ . '/../config/base.php'),
    require(__DIR__ . '/../config/web.php')
);


(new yii\web\Application($config));

use common\payment\alipay\AlipayTradeService;
use frontend\models\edu\resources\CourseOrderItem;


$alipay_config = Yii::$app->params['payment']['gedu']['alipay'];

$arr = $_POST;
if (!isset($arr) || empty($arr)) {
    return ;
}
$alipaySevice = new AlipayTradeService($alipay_config); 
$alipaySevice->writeLog(var_export($_POST,true));
$result = $alipaySevice->check($arr);
/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
fileWrite(date("Y-m-d H:i:s").'-----------'.$result);
if($result) {//验证成功

    if($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED') {
        
        $app_id       = $_POST['app_id'];           // 支付宝 APP ID
        $out_trade_no = $_POST['out_trade_no'];     // 商户订单号
        $trade_no     = $_POST['trade_no'];         // 支付宝交易号
        $total_amount = $_POST['total_amount'];     // 支付宝订单金额
        $trade_status = $_POST['trade_status'];     // 交易状态

        // if ($alipay_config['app_id'] != $app_id) {
        //     fileWrite("[".date("Y-m-d H:i:s")."] Error: APP ID is not match! [app_id:".$alipay_config['app_id']."|| Received app_id:".$app_id."]");
        //     exit();
        // }

        $order = CourseOrderItem::find()->where(['order_sn'=>$out_trade_no])->one();

        // 验证订单号
        // if ($order->order_sn != $trade_no) {
        //     fileWrite("[".date("Y-m-d H:i:s")."] Error: Order Sn is not match! [order_sn:".$order->order_sn."|| trade_no:".$trade_no."]");
        //     exit();
        // }

        // 验证订单金额
        // if ($order->real_price != $total_amount) {
        //     fileWrite("[".date("Y-m-d H:i:s")."] Error: Price is not match! [real_price:".$order->real_price."|| total_amount:".$total_amount."]");
        //     exit();
        // }

        $order->payment_id     = $trade_no;
        $order->payment_status = CourseOrderItem::PAYMENT_STATUS_PAID;
        $order->payment        = CourseOrderItem::PAYMENT_ALIPAY;
        if (!$order->save()) {
            fileWrite("[".date("Y-m-d H:i:s")."] Error: Order Update Fail : ".json_encode($order->Errors())." || Notify Params : ".json_encode($_POST)."\r\n");
            exit();
        }

        //判断该笔订单是否在商户网站中已经做过处理
            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
            //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
            //如果有做过处理，不执行商户的业务程序
                
        //注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
	echo "success";		//请不要修改或删除
    exit();
    }
        
}else {
    fileWrite('fail'.$arr);
    //验证失败
    echo "fail";	//请不要修改或删除
    exit();
}

function fileWrite($data, $filename=''){
    $filename = '../runtime/payment/call_back.log';
    if(!is_file($filename)){
        return false;
    }
    $fh = fopen($filename, "a");
    $fr = fwrite($fh, $data."\r\n");
    fclose($fh);

    return $fr;
}
?>

