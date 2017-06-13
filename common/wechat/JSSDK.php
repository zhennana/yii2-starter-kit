<?php
namespace common\wechat;

use Yii;

/**
 * 获取微信使用权限签名
 */
class JSSDK {

    private $appId;
    private $appSecret;
    private $jsapiTicket;
    private $accessToken;

    /**
     * [__construct description]
     * @param [type] $appId     [description]
     * @param [type] $appSecret [description]
     */
    public function __construct($appId, $appSecret) 
    {
        $this->appId       = $appId;
        $this->appSecret   = $appSecret;
        $this->jsapiTicket = Yii::getAlias('@runtime').DIRECTORY_SEPARATOR.'jsapi_ticket.json';
        $this->accessToken = Yii::getAlias('@runtime').DIRECTORY_SEPARATOR.'access_token.json';

        // var_dump($this->jsapiTicket, $this->accessToken); exit();
    }

    /**
     * [getSignPackage description]
     * @return [type] [description]
     */
    public function getSignPackage($url = '') {
        if ($url == '') {
            $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }
        $jsapiTicket = $this->getJsApiTicket();
        if (isset($jsapiTicket->errcode)) {
            return $jsapiTicket;
        }
        $timestamp   = time();
        $nonceStr    = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=".$jsapiTicket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url."";

        // 对string进行sha1签名
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage; 
    }

    /**
     * [createNonceStr description]
     * @param  integer $length [description]
     * @return [type]          [description]
     */
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";

        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * [getJsApiTicket description]
     * @return [type] [description]
     */
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($this->jsapiTicket));

        if ($data->expire_time < time()) { 
            $accessToken = $this->getAccessToken();
            if (isset($accessToken->errcode)) {
                return $accessToken;
            }

            $url         = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$accessToken."";

            $res    = json_decode($this->httpGet($url));
            $ticket = $res->ticket;

            if ($ticket) {
                $data->expire_time  = time() + 7000;
                $data->jsapi_ticket = $ticket;

                $fp = fopen($this->jsapiTicket, "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    /**
     * [getAccessToken description]
     * @return [type] [description]
     */
    private function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents($this->accessToken));

        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->appId."&secret=".$this->appSecret."";
            $res = json_decode($this->httpGet($url));

            if (isset($res->errcode)) {
                return $res;
            }

            $access_token = $res->access_token;
            if ($res->access_token) {
                $data->expire_time  = time() + 7000;
                $data->access_token = $access_token;

                $fp = fopen($this->accessToken, "w");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    /**
     * [httpGet description]
     * @param  [type] $url [description]
     * @return [type]      [description]
     */
    private function httpGet($url) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

}


 ?>

