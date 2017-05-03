<?php
namespace frontend\models\wedu\resources;

use Yii;
use yii\base\Model;

use frontend\models\wedu\resources\User;
use common\models\UserToken;
use common\models\PhoneValidator;

/**
 * User form
 */
class UserForm extends Model
{
    //const SCENARIO_SIGNIN = 'sign_in';    // 登录
    //const SCENARIO_SIGNUP = 'sign_up';    // 注册

    /**
     * @var
     */
    public $phone_number;
    public $client_type;
    public $type;
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
            ['phone_number','is_phone'],
            ['phone_number', 'filter', 'filter' => 'trim'],
            ['phone_number', 'required'],
            ['phone_number', 'string', 'min' => 11, 'max' => 11],
            [['phone_number'], PhoneValidator::className()],
            ['token','required'],
            ['token','is_token'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['client_type', 'string', 'min' => 2, 'max' => 255],
            ['type', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'phone_number' => Yii::t('frontend', 'Phone Number'),
            'password'     => Yii::t('frontend', 'Password'),
            'client_type'  => Yii::t('frontend', 'Client Type'),
            'type'         => Yii::t('frontend', 'Type'),
        ];
    }

    /**
     * [scenarios 场景验证]
     * @return [type] [description]
     */
    /*public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SIGNIN] = [''];
        $scenarios[self::SCENARIO_SIGNUP] = [''];
        return $scenarios;
    }
    */
    /**
     * [is_token description]
     * @return boolean [description]
     */
    public function is_token()
    {
        $userToken = UserToken::find()
            ->byToken($this->token)
            ->notExpired()
            ->one();
        if (!$userToken) {
            return $this->addError('token',Yii::t('frontend', '无效的验证码'));
        }
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
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $userModel = User::find()->where([
                'phone_number'=>$this->phone_number
            ])->one();

            $this->type = ($this->type == 'signup') ? UserToken::TYPE_PHONE_SIGNUP : UserToken::TYPE_PHONE_REPASSWD;

            if($userModel && $this->type == UserToken::TYPE_PHONE_SIGNUP){
                // 
                if($userModel->status == User::STATUS_NOT_ACTIVE){
                    $token = UserToken::find()->where([
                        'user_id'=>$userModel->id
                    ])->andWhere([
                        'type'=>$this->type
                    ])->one();

                    if ($token && $token->token === $this->token) {
                        $userModel->status = User::STATUS_ACTIVE;
                        $userModel->setPassword($this->password);
                        $userModel->save();
                        $token->delete();
                        return $userModel;
                    }
                    return $this->addError('token',Yii::t('frontend','验证码不正确'));
                }
                return $this->addError('phone_number',Yii::t('frontend','该手机号已被注册过'));
            }elseif($userModel && $this->type == UserToken::TYPE_PHONE_REPASSWD){
                // 重置密码
                $token = UserToken::find()->where([
                    'user_id'=>$userModel->id
                ])->andWhere([
                    'type'=>$this->type
                ])->one();

                if ($token && $token->token === $this->token) {
                    $userModel->setPassword($this->password);
                    $userModel->save();
                    $token->delete();
                    return $userModel;
                }
                return $this->addError('token',Yii::t('frontend','验证码不正确'));
            }
        }
        $this->getErrors();
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
