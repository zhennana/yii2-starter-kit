<?php
namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use frontend\modules\user\Module;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\PhoneValidator;
use ecommon\models\user\UserAccount;

use common\components\aliyunMNS\SendSMSMessage;

/**
 * Signup form
 */
class SignupSmsForm extends Model
{
    /**
     * @var
     */
    public $phone_number;
    public $username;
    public $email;
    public $client_type;
    public $token;
    public $messageId;

    // 光大短信升级
    public $verifyCode; // 图形验证码
    public $code;       // 短信验证码
    public $code_type;  // 短信验证码类型

    /**
     * @var
     */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique',
                'targetClass'=>'\common\models\User',
                'message' => Yii::t('frontend', 'This username has already been taken.')
            ],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['phone_number','is_phone'],
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['phone_number', 'required'],
            ['phone_number', 'unique',
                'targetClass'=>'\common\models\User',
                'message' => Yii::t('frontend', 'This phone_number has already been taken.')
            ],
            ['phone_number', 'string', 'min' => 11, 'max' => 11],
            [['phone_number'], PhoneValidator::className()],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['client_type', 'string', 'min' => 2, 'max' => 255],
            ['verifyCode', 'required','on'=>'code'],
            ['verifyCode','captcha','captchaAction'=>'/gedu/v1/sign-in/captcha-v1' ,'on'=>'code'],
            ['code_type', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username'=>Yii::t('frontend', 'Username'),
            'phone_number' => Yii::t('frontend', 'Phone Number'),
            'email'=>Yii::t('frontend', 'E-mail'),
            'password'=>Yii::t('frontend', 'Password'),
            'client_type'=>Yii::t('frontend', 'Client Type'),
        ];
    }
     function is_phone()
    {
        //var_Dump($this->phone_number);exit;
        if(!preg_match("/^1[34578]{1}\d{9}$/",$this->phone_number)){
           return $this->addError('phone_number',Yii::t('frontend','手机不合法'));
        }
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['code'] = ['verifyCode'];
        return $scenarios;
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        // var_dump($this->client_type, $this->password); exit();
        if($this->client_type == 'app' && empty($this->password)){
            $this->password = UserToken::randomCode(6);
        }
        $instance = new SendSMSMessage();

        // 判断用户存在
        $user_model = User::find()->where(['phone_number'=>$this->phone_number])->one();

        if($user_model){
            if($user_model->status == User::STATUS_NOT_ACTIVE){ //未激活用户信息
                    $code = UserToken::find()->where(['user_id'=>$user_model->id])
                    ->andWhere(['type'=>UserToken::TYPE_PHONE_SIGNUP])->one();

                    if($code) {
                        $code->delete();
                    }

                    $this->token = UserToken::randomCode();
                    $token = UserToken::create(
                        $user_model->id,
                        UserToken::TYPE_PHONE_SIGNUP,
                        Time::SECONDS_IN_A_DAY,
                        $this->token
                    );
                    /*
                    ymSms([
                        'message' => $this->token.' 验证码',
                        'phone' => $user_model->phone_number,
                    ]);*/
                    $this->messageId = $instance->registerCode($user_model->phone_number,['code' => $this->token]);
            }else{
                return  $this->addError('phone_number',Yii::t('frontend','This username has already been taken.'));
            }
            return $user_model;
        }

        // 用户不存在
        if ($this->validate()) {
            //var_dump($user);exit;
                $shouldBeActivated = true;
                $user = new User();
                $user->username = $this->username;
                $user->phone_number = $this->phone_number;
                $user->email = $this->email;
                $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
                $user->setPassword($this->password);
//var_dump($user->save(),$user->getErrors()); exit();
            if(!$user->save()) {
                return $user->getErrors();
                //throw new Exception("User couldn't be  saved");
            };
            $user->afterSignup([
                'address' => '',
            ]);

            if ($shouldBeActivated) {
                $this->token = UserToken::randomCode();
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_PHONE_SIGNUP,
                    Time::SECONDS_IN_A_DAY,
                    $this->token
                );
                if($token){ // 发送短信
                    /*
                    ymSms([
                        'message'=>$this->token.' 验证码',
                        'phone'=>$user->phone_number,
                    ]);
                    */
                    $this->messageId = $instance->registerCode($user->phone_number,['code' => $this->token]);
                }
            }
                //$account  = new UserAccount();
                //$account->id = $user->id;
                //$account->save();
                //$url = Url::to(['/user/sign-in/activation', 'token' => $token->token], true);
                /*
                Yii::$app->commandBus->handle(new SendEmailCommand([
                    'subject' => Yii::t('frontend', 'Activation email'),
                    'view' => 'activation',
                    'params' => [
                        'url' => Url::to(['/user/sign-in/activation', 'token' => $token->token], true)
                    ]
                ]));
                */
            return $user;
        }else{
            //var_dump($this->getErrors());exit;
             $this->getErrors();
        }
    }

    /**
     *  [signupV1 注册短信接口升级(光大)]
     *  @return [type] [description]
     */
    public function signupV1(){
        $info =[
            'error_code' => '0',
            'message'    => '获取成功',
            'resources'  => [],
        ];
        $verification = [
            'validation_level' =>'0',
            'graphical_url'    =>'',
        ];
        $this->password = UserToken::randomCode(6);

        $user_model = User::find()
            ->where(['phone_number'=>$this->phone_number])
            ->one();
        if (!$user_model && $this->code_type == UserToken::TYPE_PHONE_REPASSWD) {
            $info['error_code'] = __LINE__;
            $info['message'] = '该手机号未注册';
            return $info;
        }

        //这里是未认证的用户重新发送验证码
        if($user_model){
            if ($user_model->status == User::STATUS_ACTIVE && $this->code_type == UserToken::TYPE_PHONE_SIGNUP) {
                $info['error_code'] = __LINE__;
                $info['message'] = '该手机号已注册';
                return $info;
            }
            if ($user_model->status == User::STATUS_NOT_ACTIVE && $this->code_type == UserToken::TYPE_PHONE_REPASSWD) {
                $info['error_code'] = __LINE__;
                $info['message'] = '该手机号未注册';
                return $info;
            }
            //如果未激活状态 重新获取验证码发送短信
            if($this->beforeSend()){
                //放置图形验证码
                $verification['validation_level'] = '1';
                $verification['graphical_url'] = Yii::$app->request->hostInfo.Url::to(['gedu/v1/sign-in/captcha-v1']);
                $info['resources'] = ArrayHelper::merge($user_model->toArray(['id','phone_number']),$verification);
                return $info;
            }
            $sms  = $this->smsSend($user_model,$this->code_type);
            if($this->hasErrors()){
               $info['error_code'] = __LINE__;
               $info['message']    = $this->getFirstErrors();
               return $info;
            }
            return ArrayHelper::merge($user_model,$verification);
        }
        
        //这里是新用户注册
        if($this->validate()){
            $shouldBeActivated = true;
            $user = new User();
            $user->username = $this->username;
            $user->phone_number = $this->phone_number;
            // $user->email = $this->email;
            $user->status = $shouldBeActivated ? User::STATUS_NOT_ACTIVE : User::STATUS_ACTIVE;
            $user->setPassword($this->password);
            if(!$user->save()) {
                $info['error_code'] = __LINE__;
                $info['message']    = $user->getFirstErrors();
               return $info;
            };
            $user->afterSignup();
            if($this->beforeSend()){
                $verification['validation_level'] = '1';
                $verification['graphical_url'] = Yii::$app->request->hostInfo.Url::to(['gedu/v1/sign-in/captcha-v1']);
                $info['resources'] = ArrayHelper::merge($user->toArray(['id','phone_number']),$verification);
                return $info;
            }

            $this->smsSend($user,$this->code_type);
            if($this->hasErrors()){
                $info['error_code'] = __LINE__;
                $info['message']    = $this->getFirstErrors();
                return $info;
            }
             $info['resources'] = ArrayHelper::merge($user,$yanzhema);
             return $info;
        }else{
            //返回报错信息
            $info['error_code'] = __LINE__;
            $info['message']    = $this->getFirstErrors();
            return $info;
        }
    }
//发送短信
    public function smsSend($user,$type){
        //这里要发送短信之前要做的事
        $code = $this->getToke($user->id,$type);
        if(!$code){
            $this->addError('code','获取验证码失败,请重新发送');
            return $this;
        }
        $sms = new \common\components\submail\SmsMessageXsend();
        $response = $sms->registerCode($user->phone_number,$code);
        if($response['status'] !== 'success' ){
            $this->addError('code',$response['msg']);
        }
        return $this;
    }
    //在发送之前要做的事
    public function beforeSend(){
        return true;
    }

    //获取验证码
    public function getToke($user_id,$type){
        $token = UserToken::find()
            ->andwhere(['user_id'=>$user_id])
            ->byType($type)
            ->notExpired()
            ->one();
        if(!$token){
            $code = UserToken::randomCode(6);
            $this->code = $code;
            $token = UserToken::create(
                $user_id,$type,10*60,$code
            );
        }
        if($token){
           return  $token->token;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function shouldBeActivated()
    {
        /** @var Module $userModule */
        $userModule = Yii::$app->getModule('user');
        if (!$userModule) {
            return false;
        } elseif ($userModule->shouldBeActivated) {
            return true;
        } else {
            return false;
        }
    }
}
