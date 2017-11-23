<?php
namespace common\components\submail;

use Yii;
use common\components\submail\MessageXsend;

/**
* 
*/
class SmsMessageXsend {
    
    public $_config = [];

    /**
     *  [getConfig 获取短信配置参数]
     *  @param  string $key [description]
     *  @return [type]      [description]
     */
    public function getConfig($key = 'submail.sms.configs'){
        $stringConfig = Yii::$app->keyStorage->get($key);

        if(!$stringConfig)
        {
            return false;
        }

        $value = explode(';', $stringConfig);
        $this->_config['appid']     = isset($value[0]) ? $value[0] : '';
        $this->_config['appkey']    = isset($value[1]) ? $value[1] : '';
        $this->_config['sign_type'] = isset($value[2]) ? $value[2] : 'md5';

        return true;
    }
    /**
     *  [registerCode 调用短信接口]
     *  @param  [type] $project      [模版ID]
     *  @param  [type] $phone_number [目标手机号]
     *  @param  [type] $code         [验证码]
     *  @return [type]               [description]
     */
    public function registerCode($phone_number,$code,$project='BcCiN1')
    {
        $this->getConfig();
// var_dump($this->_config);exit;
        $submail = new MessageXsend($this->_config);
        $submail->setTo($phone_number);
        $submail->SetProject($project);
        $submail->AddVar('code',$code);

        $xsend = $submail->xsend();

        return $xsend;
    }

}
