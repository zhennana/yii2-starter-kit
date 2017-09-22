<?php
namespace common\payment\wechatpay;

class WechatPay {
    
    const TRADETYPE_JSAPI = 'JSAPI',TRADETYPE_NATIVE = 'NATIVE',TRADETYPE_APP = 'APP';
    //预支付创建订单
    const URL_UNIFIEDORDER = "https://api.mch.weixin.qq.com/pay/unifiedorder";

    const URL_ORDERQUERY = "https://api.mch.weixin.qq.com/pay/orderquery";
    const URL_CLOSEORDER = 'https://api.mch.weixin.qq.com/pay/closeorder';
    const URL_REFUND = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    const URL_REFUNDQUERY = 'https://api.mch.weixin.qq.com/pay/refundquery';
    const URL_DOWNLOADBILL = 'https://api.mch.weixin.qq.com/pay/downloadbill';
    const URL_REPORT = 'https://api.mch.weixin.qq.com/payitil/report';
    const URL_SHORTURL = 'https://api.mch.weixin.qq.com/tools/shorturl';
    const URL_MICROPAY = 'https://api.mch.weixin.qq.com/pay/micropay';

    /**
     * 错误信息
     */
    public $error = null;
    /**
     * 错误信息XML
     */
    public $errorXML = null;
    /**
     * 微信支付配置数组
     * appid        公众账号appid
     * mch_id       商户号
     * apikey       加密key
     * appsecret    公众号appsecret
     * sslcertPath  证书路径(apiclient_cert.pem)
     * sslkeyPath   密钥路径(apiclient_key.pem)
     */
    private $_config;

    /**
     * @param $config 微信支付配置数组
     */
    public function __construct($config) {
        $this->_config = $config;
    }

    /**
     * 获取prepay_id
     * @param $body
     * @param $out_trade_no
     * @param $total_fee
     * @param $notify_url
     * @param $openid
     * @param array $ext
     * @return null
     */
    public function getPrepayId($datas, $openid = NULL, $ext = null) {
        $data = $ext?:[];

        $data["fee_type"]         = $this->_config['fee_type'];
        $data["notify_url"]       = $this->_config['notify_url'];

        $data["body"]             = $datas['body'];
        $data["out_trade_no"]     = $datas['out_trade_no'];
        $data["total_fee"]        = $datas['total_fee'];
        $data["spbill_create_ip"] = $datas['spbill_create_ip'];

        $data["openid"]           = $openid;
// var_Dump($data);exit;

        $result = $this->unifiedOrder($data);
        if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return $result['prepay_id'];
        } else {
            $this->error = $result["return_code"] == "SUCCESS" ? $result["err_code_des"] : $result["return_msg"];
            $this->errorXML = $this->array2xml($result);
            return null;
        }
    }

    private function get_nonce_string() {
        return substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"),0,32);
    }

    /**
     * 统一下单接口
     */
    public function unifiedOrder($params) {
        $data = [];

        // required
        $data["appid"]            = $this->_config["appid"];
        $data["mch_id"]           = $this->_config["mch_id"];
        $data["trade_type"]       = $this->_config['trade_type'];

        $data["nonce_str"]        = $this->get_nonce_string();

        $data["body"]             = $params['body'];
        $data["out_trade_no"]     = $params['out_trade_no'];
        $data["total_fee"]        = $params['total_fee'];
        $data["spbill_create_ip"] = $params['spbill_create_ip'];
        $data["notify_url"]       = $params['notify_url'];

        // optional
        $data["device_info"] = (isset($params['device_info'])&&trim($params['device_info'])!='')?$params['device_info']:null; //optional
        $data["detail"]           = isset($params['detail'])?$params['detail']:null;//optional
        $data["attach"]           = isset($params['attach'])?$params['attach']:null;//optional
        $data["fee_type"]         = isset($params['fee_type'])?$params['fee_type']:'CNY';//optional
        $data["time_start"]       = isset($params['time_start'])?$params['time_start']:null;//optional
        $data["time_expire"]      = isset($params['time_expire'])?$params['time_expire']:null;//optional
        $data["goods_tag"]        = isset($params['goods_tag'])?$params['goods_tag']:null;//optional

        // $data['sign_type']        = 'MD5';//默认MD5 optional
        // $data["limit_pay"]        = isset($params['limit_pay'])?$params['limit_pay']:null;//optional
        // $data["scene_info"]       = isset($params['scene_info'])?$params['scene_info']:null;//optional

        // $data["product_id"]       = isset($params['product_id'])?$params['product_id']:null;//required when trade_type = NATIVE
        // $data["openid"]           = isset($params['openid'])?$params['openid']:null;//required when trade_type = JSAPI

        $result = $this->post(self::URL_UNIFIEDORDER, $data);
        return $result;
    }
    /**
     * 给微信发起网络请求。如果是https协议需要用到证书，目前是http协议无需证书
     * @param  [type]  $url  [description]//微信接口地址
     * @param  [type]  $data [description]//给微信传的参数
     * @param  boolean $cert [description]
     * @return [type]        [description]
     */
    private function post($url, $data,$cert = false) {
        if(!isset($data['sign'])) $data["sign"] = $this->sign($data);

        $xml = $this->array2xml($data);
    //var_dump($xml);exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        if($cert == true){
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, $this->_config['sslcertPath']);
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, $this->_config['sslkeyPath']);
        }
        $content = curl_exec($ch);
        //var_dump($content);exit;
        $array = $this->xml2array($content);
        return $array;
    }

    /**
     * 扫码支付(模式二)获取支付二维码
     * @param $body
     * @param $out_trade_no
     * @param $total_fee
     * @param $notify_url
     * @param $product_id
     * @return null
     */
    public function getCodeUrl($body,$out_trade_no,$total_fee,$notify_url,$product_id,$ext = null){
        $data = $ext?:[];
        $data["nonce_str"]    = $this->get_nonce_string();
        $data["body"]         = $body;
        $data["out_trade_no"] = $out_trade_no;
        $data["total_fee"]    = $total_fee;
        $data["spbill_create_ip"] = $_SERVER["SERVER_ADDR"];
        $data["notify_url"]   = $notify_url;
        $data["trade_type"]   = self::TRADETYPE_NATIVE;
        $data["product_id"]   = $product_id;
        //var_dump($data);exit;
        $result = $this->unifiedOrder($data);
        if ($result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
            return $result["code_url"];
        } else {
            $this->error = $result["return_code"] == "SUCCESS" ? $result["err_code_des"] : $result["return_msg"];
            return null;
        }
    }

    /**
     * 查询订单
     * @param $transaction_id
     * @param $out_trade_no
     * @return array
     */
    public function orderQuery($transaction_id,$out_trade_no){
        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["transaction_id"] = $transaction_id;
        $data["out_trade_no"] = $out_trade_no;
        $data["nonce_str"] = $this->get_nonce_string();
        $result = $this->post(self::URL_ORDERQUERY, $data);
        return $result;
    }

    /**
     * 关闭订单
     * @param $out_trade_no
     * @return array
     */
    public function closeOrder($out_trade_no){
        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["out_trade_no"] = $out_trade_no;
        $data["nonce_str"] = $this->get_nonce_string();
        $result = $this->post(self::URL_CLOSEORDER, $data);
        return $result;
    }

    /**
     * 申请退款 - 使用商户订单号
     * @param $out_trade_no 商户订单号
     * @param $out_refund_no 退款单号
     * @param $total_fee 总金额（单位：分）
     * @param $refund_fee 退款金额（单位：分）
     * @param $op_user_id 操作员账号
     * @return array
     */
    public function refund($out_trade_no,$out_refund_no,$total_fee,$refund_fee,$op_user_id){
        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["nonce_str"] = $this->get_nonce_string();
        $data["out_trade_no"] = $out_trade_no;
        $data["out_refund_no"] = $out_refund_no;
        $data["total_fee"] = $total_fee;
        $data["refund_fee"] = $refund_fee;
        $data["op_user_id"] = $op_user_id;
        $result = $this->post(self::URL_REFUND, $data,true);

        return $result;
    }

    /**
     * 申请退款 - 使用微信订单号
     * @param $transaction_id 微信订单号
     * @param $out_refund_no 退款单号
     * @param $total_fee 总金额（单位：分）
     * @param $refund_fee 退款金额（单位：分）
     * @param $op_user_id 操作员账号
     * @return array
     */
    public function refundByTransId($params){

        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["nonce_str"] = $this->get_nonce_string();
        $data["transaction_id"] =$params['transaction_id'];
        $data["out_refund_no"] = $params['out_refund_no'];
        $data["total_fee"] = $params['total_fee'];
        $data["refund_fee"] = $params['refund_fee'];
        $data["op_user_id"] = $params['op_user_id'];

        $result = $this->post(self::URL_REFUND, $data,true);
        return $result;
    }
    /**
     * 下载对账单
     * @param $bill_date 下载对账单的日期，格式：20140603
     * @param string $bill_type 类型
     * @return array
     */
    public function downloadBill($bill_date,$bill_type = 'ALL'){
        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["bill_date"] = $bill_date;
        $data["bill_type"] = $bill_type;
        $data["nonce_str"] = $this->get_nonce_string();
        $result = $this->post(self::URL_DOWNLOADBILL, $data);
        return $result;
    }

    /**
     * 扫码原生支付模式一中的二维码链接转成短链接
     * @param $long_url 需要转换的URL，签名用原串，传输需URLencode
     * @return array
     */
    public function shortUrl($long_url){
        $data = array();
        $data["appid"] = $this->_config["appid"];
        $data["mch_id"] = $this->_config["mch_id"];
        $data["long_url"] = $long_url;
        $data["nonce_str"] = $this->get_nonce_string();
        $data["sign"] = $this->sign($data);
        $data["long_url"] = urlencode($long_url);
        $result = $this->post(self::URL_SHORTURL, $data);
        return $result;
    }

    /**
     * 获取app支付所需参数
     */
    public function get_package($prepay_id) {
        $data = array();
        $data["appid"]     = $this->_config["appid"];
        $data['partnerid'] = $this->_config["mch_id"];
        $data['prepayid']  = $prepay_id;
        $data["package"]   = "Sign=WXPay";
        $data["noncestr"]  = $this->get_nonce_string();
        //解决微信支付调用JSAPI缺少参数：timeStamp
        $data["timestamp"] = time();
        $data["sign"]      = $this->sign($data);

        return $data;
    }

    /**
     * 获取发送到通知地址的数据(在通知地址内使用)
     * @return 结果数组，如果不是微信服务器发送的数据返回null
     *          appid
     *          bank_type
     *          cash_fee
     *          fee_type
     *          is_subscribe
     *          mch_id
     *          nonce_str
     *          openid
     *          out_trade_no    商户订单号
     *          result_code
     *          return_code
     *          sign
     *          time_end
     *          total_fee       总金额
     *          trade_type
     *          transaction_id  微信支付订单号
     */
    public function get_back_data() {
        $xml = file_get_contents("php://input");
        $data = $this->xml2array($xml);
        if ($this->validate($data)) {
            return $data;
        } else {
            return null;
        }
    }

    /**
     * 验证数据签名
     * @param $data 数据数组
     * @return 数据校验结果
     */
    public function validate($data) {
        if (!isset($data["sign"])) {
            return false;
        }
        $sign = $data["sign"];
        unset($data["sign"]);
        return $this->sign($data) == $sign;
    }

    /**
     * 响应微信支付后台通知
     * @param string $return_code 返回状态码 SUCCESS/FAIL
     * @param $return_msg  返回信息
     */
    public function response_back($return_code="SUCCESS", $return_msg=null) {
        $data = array();
        $data["return_code"] = $return_code;
        if ($return_msg) {
            $data["return_msg"] = $return_msg;
        }
        $xml = $this->array2xml($data);
        print $xml;
    }

    /**
     * 数据签名
     * @param $data
     * @return string
     */
    private function sign($data) {
        ksort($data);
        $string1 = "";
        foreach ($data as $k => $v) {
            if ($v && trim($v)!='') {
                $string1 .= "$k=$v&";
            }
        }
        $stringSignTemp = $string1 . "key=" . $this->_config["apikey"];
        $sign = strtoupper(md5($stringSignTemp));
        return $sign;
    }

    private function array2xml($array) {
        ksort($array);
        $xml = "<xml>";
        foreach ($array as $k => $v) {
            if($v && trim($v)!='')
                $xml .= "<$k>$v</$k>";
        }
        $xml .= "</xml>";
        return $xml;
    }

    private function xml2array($xml) {
        $array = array();
        $tmp = null;
        try{
            $tmp = (array) simplexml_load_string($xml);
        }catch(Exception $e){}
        if($tmp && is_array($tmp)){
            foreach ( $tmp as $k => $v) {
                $array[$k] = (string) $v;
            }
        }
        return $array;
    }

    //请确保项目文件有可写权限，不然打印不了日志。
    function writeLog($text) {
        // $text=iconv("GBK", "UTF-8//IGNORE", $text);
        //$text = characet ( $text );
        // var_dump(dirname ( __FILE__ ).DIRECTORY_SEPARATOR."../../../frontend/runtime/payment/call_back.log", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND);exit;
        file_put_contents ( dirname ( __FILE__ ).DIRECTORY_SEPARATOR."../../../frontend/runtime/payment/call_back.log", date ( "Y-m-d H:i:s" ) . "  " . $text . "\r\n", FILE_APPEND );
    }

}