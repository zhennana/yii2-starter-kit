<?php
namespace backend\modules\user\models;

use cheatsheet\Time;
use common\commands\SendEmailCommand;
use common\models\User;
use common\models\UserToken;
use backend\modules\user\Module;
use yii\base\Exception;
use yii\base\Model;
use Yii;
use yii\helpers\Url;
use common\models\PhoneValidator;
//use ecommon\models\user\UserAccount;
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
        $user_model = User::find()->where(['phone_number'=>$this->phone_number])->one();
        if($user_model){
            if($user_model->status == User::STATUS_NOT_ACTIVE){ //未激活用户信息
                    $code = UserToken::find()->where(['user_id'=>$user_model->id])
                    ->andWhere(['type'=>UserToken::TYPE_PHONE_SINGUP])->one();

                    $code->delete();
                    $this->token = UserToken::randomCode();
                    $token = UserToken::create(
                        $user_model->id,
                        UserToken::TYPE_PHONE_SINGUP,
                        Time::SECONDS_IN_A_DAY,
                        $this->token
                    );

                    ymSms([
                        'message' => $this->token.' 验证码',
                        'phone' => $user_model->phone_number,
                    ]);
            }else{
                return  $this->addError('phone_number',Yii::t('frontend','This username has already been taken.'));
            }
            return $user_model;
        }
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
            $user->afterSignup();
            if ($shouldBeActivated) {
                $this->token = UserToken::randomCode();
                $token = UserToken::create(
                    $user->id,
                    UserToken::TYPE_PHONE_SINGUP,
                    Time::SECONDS_IN_A_DAY,
                    $this->token
                );
                if($token){ // 发送短信
                    ymSms([
                        'message'=>$this->token.' 验证码',
                        'phone'=>$user->phone_number,
                    ]);
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
