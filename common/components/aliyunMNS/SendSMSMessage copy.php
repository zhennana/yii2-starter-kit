<?php
namespace common\components\aliyunMNS;

use AliyunMNS\Client;
use AliyunMNS\Topic;
use AliyunMNS\Constants;
use AliyunMNS\Model\MailAttributes;
use AliyunMNS\Model\SmsAttributes;
use AliyunMNS\Model\BatchSmsAttributes;
use AliyunMNS\Model\MessageAttributes;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\PublishMessageRequest;

use Yii;
use yii\base\Component;
use yii\db\Connection;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class SendSMSMessage
{
    public $_config = [];

    /**
     * [获取发送模板信息]
     * 
     * key    aliyun.sms.register.code
     * value  endPoint;accessId;accessKey;SMSSignName;SMSTemplateCode
     * 
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function getConfig($key = 'aliyun.sms.register.code'){
        $stringConfig = Yii::$app->keyStorage->get($key);

        if(!$stringConfig)
        {
            return false;
        }

        $value = explode(';', $stringConfig);
        $this->_config['endPoint']          = isset($value[0]) ? $value[0] : '';
        $this->_config['accessId']          = isset($value[1]) ? $value[1] : '';
        $this->_config['accessKey']         = isset($value[2]) ? $value[2] : '';
        $this->_config['SMSSignName']       = isset($value[3]) ? $value[3] : '';
        $this->_config['SMSTemplateCode']   = isset($value[4]) ? $value[4] : '';

        return true;
    }

    public function registerCode($phone_number, $params)
    {
        $this->getConfig();
        $this->client = new Client($this->_config['endPoint'], $this->_config['accessId'], $this->_config['accessKey']);

        /**
         * Step 2. 获取主题引用
         */
        $topicName = "sms.topic-cn-hangzhou";
        $topic = $this->client->getTopicRef($topicName);

        /**
         * Step 3. 生成SMS消息属性
         */
        // 3.1 设置发送短信的签名（SMSSignName）和模板（SMSTemplateCode）
        $batchSmsAttributes = new BatchSmsAttributes($this->_config['SMSSignName'], $this->_config['SMSTemplateCode']);

        // 3.2 （如果在短信模板中定义了参数）指定短信模板中对应参数的值
        $batchSmsAttributes->addReceiver($phone_number, $params);
        //$batchSmsAttributes->addReceiver("13910408910", array("code" => "12345"));
        $messageAttributes = new MessageAttributes(array($batchSmsAttributes));
        /**
         * Step 4. 设置SMS消息体（必须）
         *
         * 注：目前暂时不支持消息内容为空，需要指定消息内容，不为空即可。
         */
         $messageBody = "smsmessage";
        /**
         * Step 5. 发布SMS消息
         */
        $request = new PublishMessageRequest($messageBody, $messageAttributes);
 
        try
        {
            $res = $topic->publishMessage($request);
            /*
            print_r($res);
            echo 'Succeed: '.$res->isSucceed();
            echo "<br />";
            echo 'statusCode: '. $res->getStatusCode();
            echo '<br />';
            echo 'MessageId: '.$res->getMessageId();
            echo "<br />";*/
        }
        catch (MnsException $e)
        {
            //  throw new Exception($e, 1);
            //echo $e;
            //echo "\n";
        }

        return $res->getMessageId();
    }




}


