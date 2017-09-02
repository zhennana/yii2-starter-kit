<?php
namespace frontend\modules\user\models;

use cheatsheet\Time;
use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $identity;
    public $password;
    public $rememberMe = true;
    public $udid;

    private $user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['identity', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            [['udid'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'identity'=>Yii::t('frontend', 'Username or email'),
            'password'=>Yii::t('frontend', 'Password'),
            'rememberMe'=>Yii::t('frontend', 'Remember Me'),
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('frontend', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->rememberMe ? Time::SECONDS_IN_A_MONTH : 0)) {
                
                return true;
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->user === false) {
            $this->user = User::find()
                ->active()
                ->andWhere(['or',['phone_number'=>$this->identity], ['username'=>$this->identity], ['email'=>$this->identity]])
                ->one();
        }

        return $this->user;
    }

    public function updateSession($user_id, $udid = ''){
//Yii::$app->session->destroySession('v56sq6gd40kv41fp6k6nevdv60');
        // 更新最新的udid
        if(!empty($udid)){
            return null;  
        }
        $res = Yii::$app->session->db->createCommand()
        ->update(
            Yii::$app->session->sessionTable,
            [
                'udid' => $udid,
                'user_id' => $user_id
            ],
            "id =  '". Yii::$app->session->id . "'"
        )->execute();
//var_dump(Yii::$app->session->id); exit();
        // 
        // Yii::$app->user->logout();
        
        $data = (new \yii\db\Query())
        ->select('id, user_id, udid')
        ->from(Yii::$app->session->sessionTable)
        ->where('user_id = '.$user_id)
        ->all();
// var_dump($data); exit();
        foreach ($data as $key => $value) {
            if(empty($value['udid']) || $value['udid'] != $udid){
                Yii::$app->session->destroySession($value['id']);
            }
        }

    }

    public function oneChecker($udid)
    {
        $data = [];
        if(!Yii::$app->user->isGuest)  
        {  
            $id = Yii::$app->user->id;  
            $session = Yii::$app->session;  
            $username = Yii::$app->user->identity->username;  
            $udid_new = Yii::$app->session->get('user.udid');

            $session_data  = new yii\web\DbSession();

            // 旧设备ID
            $data = (new \yii\db\Query())
            ->select('id,user_id,udid')
            ->from($session_data->sessionTable)
            ->where('user_id = '.$id)
            ->one();

            if(!isset($data['udid']) || empty($data['udid'])){
                return $data;
            }
/*
var_dump($data['udid'] != $udid_new);
var_dump($data['udid'], $udid_new); 
// var_dump(Yii::$app->user->logout(), Yii::$app->user->isGuest);
exit();
*/

            if($data['udid'] != $udid_new)  //两个设备，下线旧设备 
            {  
                //$session_data->destroySession($data['id']);
                //Yii::$app->user->logout(); //执行登出操作
                $session  = new yii\web\DbSession();
                $session->db->createCommand()
                ->update(
                    $session->sessionTable,
                    [
                        'expire' => time()-1000,
                    ],
                    "udid =  '". $data['udid'] . "'"
                )->execute();
                
                Yii::$app->run();  

            }
        }
        $data['udid_new'] = $udid_new; 
        return $data;
    }

}
