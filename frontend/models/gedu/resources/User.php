<?php
namespace frontend\models\gedu\resources;

use yii;
use common\models\User as BaseUser;
use common\models\PhoneValidator;
/**
* 
*/
class User extends BaseUser
{
    
    public function rules()
    {
        return [
            ['phone_number', 'is_phone'],
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['phone_number', 'required'],
            ['phone_number', 'string', 'min' => 11, 'max' => 11],
            [['phone_number'], PhoneValidator::className()],
        ];
    }

    /**
     * [is_phone 验证手机号格式]
     * @return boolean [description]
     */
    function is_phone()
    {
        if(!preg_match("/^1[34578]{1}\d{9}$/",$this->phone_number)){
           return $this->addError('phone_number',Yii::t('frontend','不合法的手机号'));
        }
    }
}
?>