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
    require(__DIR__ . '/../../frontend/config/web.php'),
    require(__DIR__ . '/../config/base.php'),
    require(__DIR__ . '/../config/web.php')
);


(new yii\web\Application($config));

use common\payment\alipay\AlipayTradeService;
use frontend\models\gedu\resources\CourseOrderItem;


$alipay_config = Yii::$app->params['payment']['gedu']['alipay'];
$alipay_config['merchant_private_key'] = file_get_contents($alipay_config['merchant_private_key']);
$alipay_config['alipay_public_key'] = file_get_contents($alipay_config['alipay_public_key']);

/*

// 返回数据示例
$_POST = [
    'gmt_create'       => '2017-07-19 11:35:44',
    'charset'          => 'UTF-8',
    'seller_email'     => 'guangdaschool@sina.com',
    'subject'          => '【光大】麦克米伦小学美语',
    'sign'             => 'gauqm6ZQP7eXpDEzJLesgNzYyaHXXC1j+1yL5AhHWznmMWqOp6+4BCcU4vUU9+S/48quCxnKDtrEOKGkVw0cg+cvbvxsin4UZ/6zNtZW1RU15NedK7ILnicPA0oEhdQWXohSoF1i2hBpFDbySuAMpG8imgjRMpZ7Btj2ntQhfTg=',
    'body'             => '【光大】麦克米伦小学美语(共5节课程)',
    'buyer_id'         => '2088712412045842',
    'invoice_amount'   => '0.01',
    'notify_id'        => 'c4508b4221288e7173236b0db125c14mhe',
    'fund_bill_list'   => '[{"amount":"0.01","fundChannel":"ALIPAYACCOUNT"}]',
    'notify_type'      => 'trade_status_sync',
    'trade_status'     => 'TRADE_SUCCESS',
    'receipt_amount'   => '0.01',
    'app_id'           => '2017071107712808',
    'buyer_pay_amount' => '0.01',
    'sign_type'        => 'RSA',
    'seller_id'        => '2088721347378596',
    'gmt_payment'      => '2017-07-19 11:35:45',
    'notify_time'      => '2017-07-19 12:59:42',
    'version'          => '1.0',
    'out_trade_no'     => 'H718652329404456',
    'total_amount'     => '0.01',
    'trade_no'         => '2017071921001004840274141522',
    'auth_app_id'      => '2017071107712808',
    'buyer_logon_id'   => '554***@qq.com',
    'point_amount'     => '0.00',
];
*/
$arr = $_POST;
if (!isset($arr) || empty($arr)) {
    exit();
}
$alipaySevice = new AlipayTradeService($alipay_config); 

// 写日志
$alipaySevice->writeLog('[from notify page] [Logs]: Alipay Data:'.var_export($arr,true));

// 验签
$result = $alipaySevice->check($arr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功

    if($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED') {
        
        $app_id       = $_POST['app_id'];           // 支付宝 APP ID
        $out_trade_no = $_POST['out_trade_no'];     // 商户订单号
        $trade_no     = $_POST['trade_no'];         // 支付宝交易号
        $total_amount = $_POST['total_amount'];     // 支付宝订单金额
        $trade_status = $_POST['trade_status'];     // 交易状态

        // 验证APP ID
        if ($alipay_config['app_id'] != $app_id) {
            $alipaySevice->writeLog('[from notify page] [Alipay AppId Not Match]: config:'.var_export($alipay_config['app_id'],true).' || response:'.var_export($app_id,true));
            exit();
        }

        // 根据返回商户订单号查询订单
        $order = CourseOrderItem::find()->where(['order_sn' => $out_trade_no])->one();
        if ($order) {

            // 验证订单号
            if ($order->order_sn != $out_trade_no) {
                $alipaySevice->writeLog('[from notify page] [Order Sn Not Match]: config:'.var_export($order->order_sn,true).' || alipay:'.var_export($out_trade_no,true));
                exit();
            }

            // 验证订单金额
            if ($order->real_price != $total_amount) {
                $alipaySevice->writeLog('[from notify page] [Order Price Not Match]: config:'.var_export($order->real_price,true).' || alipay:'.var_export($total_amount,true));
                exit();
            }

            // 如果订单状态不是已支付
            if ($order->payment_status == CourseOrderItem::PAYMENT_STATUS_NON_PAID || $order->payment_status == CourseOrderItem::PAYMENT_STATUS_CONFIRMING) {
                $order->payment_id     = $trade_no;
                $order->payment_status = CourseOrderItem::PAYMENT_STATUS_PAID;
                $order->payment        = CourseOrderItem::PAYMENT_ALIPAY;
                if (!$order->save()) {
                    $alipaySevice->writeLog('[from notify page] [Order Update Fail]:'.var_export($order->getErrors(),true));
                    exit();
                }
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

    }
        
}else {
    $alipaySevice->writeLog('[from notify page] [Fail Logs]: result:'.var_export($result,true).'|| Post Data:'.var_export($arr,true));
    //验证失败
    echo "fail";	//请不要修改或删除
    exit();
}

?>

