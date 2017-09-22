<?php
/* *
 * 功能：微信支付服务器异步通知页面
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 通知频率为15/15/30/180/1800/1800/1800/1800/3600，单位：秒
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

use common\payment\wechatpay\WechatPay;
use frontend\models\gedu\resources\CourseOrderItem;


	$wechatpay_config = Yii::$app->params['payment']['gedu']['wechatpay'];

	$data    = null;
	$success = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
	$fail = '<xml><return_code><![CDATA[FAIL]]></return_code></xml>';

	$wechatPay = new WechatPay($wechatpay_config);

	//验证签名。
	$data = $wechatPay->get_back_data();

	if(empty($data)){

    	$wechatPay->writeLog('[from notify page][WeChat][Fail Logs]: Verify sign failed.');
    	//验证失败
    	echo $fail;
		return false;
    	exit();
	}

// 写日志
$wechatPay->writeLog('[from notify page][WeChat][Logs]: Data:'.var_export($data));

	if($data['return_code'] == 'SUCCESS' && $data['result_code'] == 'SUCCESS'){

		$appid         = $data['appid'];           	// 微信 APP ID
		$out_trade_no   = $data['out_trade_no'];     	// 商户订单号
		$transaction_id = $data['transaction_id'];     	// 微信支付订单号
		$total_fee      = $data['total_fee']/100;     	// 订单总金额，单位为分

		// 验证APP ID
        if ($wechatpay_config['appid'] != $appid) {
            $wechatPay->writeLog('[from notify page][WeChat][AppId Not Match]: config:'.var_export($wechatpay_config['appid'],true).' || response:'.var_export($appid,true));
            exit();
        }

        // 根据返回商户订单号查询订单
        $order = CourseOrderItem::find()->where(['order_sn' => $out_trade_no])->one();
        if ($order) {

        	// 验证订单号
            if ($order->order_sn != $out_trade_no) {
                $wechatPay->writeLog('[from notify page][WeChat][Order Sn Not Match]: config:'.var_export($order->order_sn,true).' || response:'.var_export($out_trade_no,true));
                exit();
            }

            // 验证订单金额
            if ($order->real_price != $total_fee) {
                $wechatPay->writeLog('[from notify page][WeChat][Order Price Not Match]: config:'.var_export($order->real_price,true).' || response:'.var_export($total_fee,true));
                exit();
            }

            // 如果订单状态不是已支付
            if ($order->payment_status == CourseOrderItem::PAYMENT_STATUS_NON_PAID || $order->payment_status == CourseOrderItem::PAYMENT_STATUS_CONFIRMING) {
                $order->payment_id     = $transaction_id;
                $order->payment_status = CourseOrderItem::PAYMENT_STATUS_PAID;
                $order->payment        = CourseOrderItem::PAYMENT_WECHAT;
                if (!$order->save()) {
                    $wechatPay->writeLog('[from notify page][WeChat][Order Update Fail]:'.var_export($order->getErrors(),true));
                    exit();
                }
            }
        }


		header("Content-type: text/xml");
		echo $success;
		return ;


	}
	exit();


?>
