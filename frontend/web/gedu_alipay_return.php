<?php
/* *
 * 功能：支付宝页面跳转同步通知页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
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

$alipay_config = Yii::$app->params['payment']['gedu']['alipay'];

$arr = $_GET;
if (!isset($arr) || empty($arr)) {
    return ;
}

$alipaySevice = new AlipayTradeService($alipay_config); 
$result = $alipaySevice->check($arr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = htmlspecialchars($_GET['out_trade_no']);

	//支付宝交易号

	$trade_no = htmlspecialchars($_GET['trade_no']);
	var_dump($_GET);exit;
	echo "验证成功<br />外部订单号：".$out_trade_no;

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "验证失败";
}
?>
<title>支付宝手机网站支付接口</title>
	</head>
    <body>
    </body>
</html>