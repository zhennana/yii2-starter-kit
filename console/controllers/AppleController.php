<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use backend\modules\campus\models\CourseOrderItem;

class AppleController extends Controller
{
    public function actionIndex()
    {
        var_dump('OK');exit;
    }


    /** 
        苹果返回状态码
        21000 App Store无法读取你提供的JSON数据
        21002 收据数据不符合格式
        21003 收据无法被验证
        21004 你提供的共享密钥和账户的共享密钥不一致
        21005 收据服务器当前不可用
        21006 收据是有效的，但订阅服务已经过期。当收到这个信息时，解码后的收据信息也包含在返回内容中
        21007 收据信息是测试用（sandbox），但却被发送到产品环境中验证
        21008 收据信息是产品环境中使用，但却被发送到测试环境中验证

        $url = 'https://buy.itunes.apple.com/verifyReceipt';        //正式验证地址
        $url = 'https://sandbox.itunes.apple.com/verifyReceipt';    //沙盒验证地址
    */
   /**
    *  [actionValidate description]
    *  @return [type] [description]
    */
    public function actionValidate()
    {
        echo "\r\n===== Start =====\r\n";

        $start        = time();
        $response     = null;
        $is_sandbox   = false;
        $failed_count = $total_count = $success_count = 0;

        $query = CourseOrderItem::find()->where([
            'status'         => CourseOrderItem::STATUS_VALID,
            'payment'        => CourseOrderItem::PAYMENT_APPLEPAY_INAPP,
            'payment_status' => CourseOrderItem::PAYMENT_STATUS_PAID_CLIENT
        ]);

        $total_count = $query->count();
        $order = $query->all();

        foreach ($order as $key => $value) {
            if ($value) {

                // base_64解密(由于源数据经过两次base64加密，所以需要解密一次后组装json)
                // 格式化并转json
                $jsonData[$key] = json_encode(['receipt-data' => base64_decode($value->data)]);

                // 正式环境验证
                $response[$key] = $this->_httpPostData($jsonData[$key]);

                if (!$response[$key]) {
                    $log  = '[Connection time out] ';
                    $log .= '[Sandbox:'.$is_sandbox.'] ';
                    $log .= 'order_id:'.$value->course_order_item_id."\r\n";

                    //打印日志
                    $this->_writeLogs($log);
                    echo $log;
                    $failed_count++;
                    continue;
                }

                if ($response[$key]->status == 21007) {
                    // 沙盒环境验证
                    $is_sandbox = true;
                    $response[$key] = $this->_httpPostData($jsonData[$key], $is_sandbox);
                }

                if (!$response[$key]) {
                    $log  = '[Connection time out] ';
                    $log .= '[Sandbox:'.$is_sandbox.'] ';
                    $log .= 'order_id:'.$value->course_order_item_id."\r\n";

                    //打印日志
                    $this->_writeLogs($log);
                    echo $log;
                    $failed_count++;
                    continue;
                }

                if($response[$key]->status == 0){
                    $value->payment_status = CourseOrderItem::PAYMENT_STATUS_PAID_SERVER;
                    $log  = '[Verification successed] ';
                    $log .= '[Sandbox:'.$is_sandbox.'] ';
                    $log .= 'order_id:'.$value->course_order_item_id."\r\n";
                    echo $log;
                    $success_count++;
                }else{
                    $value->payment_status = CourseOrderItem::PAYMENT_STATUS_NON_PAID;
                    $log  = '[Verification failed] ';
                    $log .= '[Sandbox:'.$is_sandbox.'] ';
                    $log .= 'order_id:'.$value->course_order_item_id."\r\n";

                    //打印日志
                    $this->_writeLogs($log);
                    echo $log;
                    $failed_count++;
                }

                if (!$value->save()) {
                    $log  = '[Model save failed] ';
                    $log .= '[Sandbox:'.$is_sandbox.'] ';
                    $log .= 'order_id:'.$value->course_order_item_id."\r\n";
                    $log .= json_encode($value->getErrors());
                    $this->_writeLogs($log);
                    $failed_count++;
                }
            }
        }
        $end = time();
        $log  = "[Result]\r\n";
        $log .= ' Total: '.$total_count."\r\n";
        $log .= ' Success: '.$success_count."\r\n";
        $log .= ' Failed: '.$failed_count."\r\n";
        $log .= '[Time] '.$this->_timeDiff($start,$end)."\r\n";
        $log .= '[Memory usage] '.$this->memory_usage()."\r\n";
        $log .= '====== END ======'."\r\n";
        echo $log;
        return ;
    }


    /**
     *  [httpPostData http验证请求]
     *  @param  [type] $url         [description]
     *  @param  [type] $data_string [description]
     *  @return [type]              [description]
     */
    public function _httpPostData($data_string, $is_sandbox = false) {

        $url = 'https://buy.itunes.apple.com/verifyReceipt';
        if ($is_sandbox) {
            $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
        }

        $curl_handle = curl_init();
        curl_setopt($curl_handle,CURLOPT_URL, $url);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, true);

        // 设置超时 1秒
        // curl_setopt($curl_handle,CURLOPT_TIMEOUT,1);
        curl_setopt($curl_handle,CURLOPT_HEADER, 0);
        curl_setopt($curl_handle,CURLOPT_POST, true);
        curl_setopt($curl_handle,CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl_handle,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle,CURLOPT_SSL_VERIFYPEER, 0);
        $response_json = curl_exec($curl_handle);
        $response = json_decode($response_json);
        curl_close($curl_handle);

        return $response;
    }

    /**
     * [actionLogs 打日志]
     * @return [type] [description]
     */
    public function _writeLogs($text)
    {
        // 日志路径
        // \console\runtime\logs\apple_validate.log

        file_put_contents (
            dirname (__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'apple_validate.log',
            date ("Y-m-d H:i:s") . "  " . $text . "\r\n",
            FILE_APPEND
        );

    }

    /**
     * [_timeDiff 计算时间差]
     * @return [type] [description]
     */
    public function _timeDiff($start, $end)
    {
        $result = "0h 0m 0s";

        if ($end > $start) {
            $time   = ($end-$start)%86400;
            $hour   = floor($time/3600);
            $minute = floor($time%3600/60);
            $second = floor($time%60);
            $result = $hour."h ".$minute."m ".$second."s";
        }

        return $result;
    }

    /**
     *  [memory_usage 计算内存使用]
     *  @return [type] [description]
     */
    public function memory_usage() {
        $mem_usage = memory_get_usage(true);

        if ($mem_usage < 1024){
            $info = $mem_usage." B";
        }elseif ($mem_usage < 1048576){
            $info = round($mem_usage/1024,2)." KB";
        }else{
            $info = round($mem_usage/1048576,2)." MB";
        }

        return $info;
    }
}