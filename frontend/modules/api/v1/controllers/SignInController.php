<?php

namespace frontend\modules\api\v1\controllers;

/**
* 注册、登陆、密码找回
*/
use yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\web\Response;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\rest\OptionsAction;
use yii\widgets\ActiveForm;

use frontend\modules\user\models\LoginForm;
use frontend\modules\user\models\PasswordResetRequestForm;
use frontend\modules\user\models\ResetPasswordForm;
use frontend\modules\user\models\SignupForm;
use frontend\modules\user\models\SignupSmsForm;

use common\models\User;
use common\models\UserProfile;
use common\models\UserToken;

use common\components\Qiniu\Auth;
use common\components\Qiniu\Storage\BucketManager;

use cheatsheet\Time;

use common\components\aliyunMNS\SendSMSMessage;

class SignInController extends \common\components\ControllerFrontendApi
{
    public $modelClass = 'common\models\User';

    public function beforeAction($action)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //Yii::$app->controller->detachBehavior('access');
        return $action;
    }
    
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                    'allow' => true,
                    'matchCallback' => function ($rule, $action) {
                        return true;
                        // var_dump($this->module->id . '_' . $this->id . '_' . $action->id); exit();
                        return \Yii::$app->user->can(
                            $this->module->id . '_' . $this->id . '_' . $action->id, 
                            ['route' => true]
                        );
                    },
                    ]
                ]
                ]
            ]
        );
    }

    public function actions()
    {
        return [
            'options' => OptionsAction::class,
        ];
    }

    /**
     * @SWG\Post(path="/sign-in/login",
     *     tags={"100-SignIn-用户接口"},
     *     summary="用户登录[已经自测]",
     *     description="用户登录：成功返回用户信息；失败返回具体原因",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "LoginForm[identity]",
     *        description = "手机号、邮箱、登录名",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "LoginForm[password]",
     *        description = "密码",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "LoginForm[rememberMe]",
     *        description = "勾选记住我",
     *        required = false,
     *        type = "integer",
     *        default = 1,
     *        enum = {0,1}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success,cookie值PHPSESSID与_identity加入请求头，返回用户个人信息"
     *     ),
     *     @SWG\Response(
     *         response = 422,
     *         description = "Data Validation Failed 账号或密码错误",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     */
    public function actionLogin()
    {
        // echo $aaa;
        // "x-mobile-powered-by": "IOS/5.6.14",
        // "x-mobile-powered-by": "Android/5.6.14",
        // Yii::$app->getUser()->login($user);
        // Accept-Language  zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3
        \Yii::$app->language = 'zh-CN';
        $model = new LoginForm();
        $model->load($_POST);
        // Yii::$app->response->format = Response::FORMAT_JSON;

        if($model->login()){
            $attrUser = $model->user->attributes;
            if(isset($attrUser['password_hash'])){
                unset($attrUser['password_hash']);
            }
            $attrUser['avatar'] = '';
            $account = [];
            //$account  = $model->user->getAccount();

            $proFileUser = $model->user->userProfile;
            // 默认头像
            if(isset($proFileUser->avatar_base_url) && !empty($proFileUser->avatar_base_url))
            {
                $attrUser['avatar'] = $proFileUser->avatar_base_url.$proFileUser->avatar_path;
            }else{
                $fansMpUser = isset($model->user->fansMp) ? $model->user->fansMp : '';
                if($fansMpUser){
                    $attrUser['avatar'] = $fansMpUser->avatar;
                }
            }

            return array_merge($attrUser,$account);
        }else{
            Yii::$app->response->statusCode = 422;
            $info = $model->getErrors();
            $language['language'] = [Yii::$app->language];
            return  $model->getErrors();
            //return array_merge($info,$language);
        }
        /*
        return [
            'action' => $this->action->id,
            'post_data' => Yii::$app->request->post(),
        ];
        */
    }


    /**
     * @SWG\Get(path="/sign-in/index",
     *     tags={"100-SignIn-用户接口"},
     *     summary="登陆请求验证已经登陆[已经自测]",
     *     description="删除cookie，请求验证是否已经登陆。登陆过返回用户信息",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回登陆验证信息"
     *     )
     * )
     *
     */
    public function actionIndex()
    {
        
        if(\Yii::$app->user->isGuest){
            Yii::$app->response->statusCode = 422;
            return [
                'message' => ['未登录，登陆验证失败']
            ];
        }

        $attrUser = Yii::$app->user->identity->attributes;

        if(isset($attrUser['password_hash'])){
            unset($attrUser['password_hash']);
        }
        $attrUser['avatar'] = '';
        //$account  = Yii::$app->user->identity->getAccount();

        $proFileUser = Yii::$app->user->identity->userProfile;

        // 默认头像
        if(isset($proFileUser->avatar_base_url) && !empty($proFileUser->avatar_base_url))
        {
            $attrUser['avatar'] = $proFileUser->avatar_base_url.$proFileUser->avatar_path;
        }else{
            /*
            $fansMpUser = Yii::$app->user->identity->fansMp;
            if($fansMpUser){
                $attrUser['avatar'] = $fansMpUser->avatar;
            }
            */
        }
        //$user['roles']=\Yii::$app->authManager->getRolesByUser(\Yii::$app->user->id);
        //return  array_merge($attrUser,$account);
        return $attrUser;
    }

    /**
     * @SWG\Post(path="/sign-in/signup",
     *     tags={"100-SignIn-用户接口"},
     *     summary="用户注册[已自测]",
     *     description="成功返回注册完信息，失败返回具体原因",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "SignupSmsForm[phone_number]",
     *        description = "手机号",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "SignupSmsForm[password]",
     *        description = "密码",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "SignupSmsForm[client_type]",
     *        description = "客户端注册类型:移动端默认app",
     *        required = true,
     *        type = "string",
     *        default = "app",
     *        enum = {"app", "pc"}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "SignupSmsForm[email]",
     *        description = "Email",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "SignupSmsForm[username]",
     *        description = "用户名",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "注册成功，短信验证码"
     *     ),
     *     @SWG\Response(
     *         response = 422,
     *         description = "Data Validation Failed 账号或密码错误",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     */
    /**
     * 注册
     * @return string|Response
     */
    public function actionSignup()
    {
        // exit(); // 暂停测试注册，上线后开放
        \Yii::$app->language = 'zh-CN';
        $model = new SignupSmsForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if (isset($user->id)) {
                if ($model->shouldBeActivated()) {
                    return [
                        'message' => Yii::t(
                            'frontend',
                            'Your account has been successfully created. Check your email for further instructions.'
                        ),
                        'user' => $user->attributes,
                    ];
                } else {
                    Yii::$app->getUser()->login($user);
                }
                //$account  = $user->getAccount();
                return array_merge($user->attributes, ['token'=>$model->token, 'messageId'=> $model->messageId]);
                //return $user->attributes;
            }
        }

        Yii::$app->response->statusCode = 422;
         //var_dump($model->getErrors());exit;
        return $model->getErrors();
    }

    /**
     * @SWG\POST(path="/sign-in/smscode",
     *     tags={"100-SignIn-用户接口"},
     *     summary="验证码有效性[已经自测]",
     *     description="激活用户状态user.status",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "token",
     *        description = "验证码",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "phone_number",
     *        description = "手机号",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "验证码是否有效"
     *     )
     * )
     *
     */
    /**
     * 验证码用户激活
     * @return string|Response
     */
    public function actionSmscode()
    {
        $token = Yii::$app->request->post('token',0);
        $userToken = UserToken::find()
            //->byType(UserToken::TYPE_PHONE_SIGNUP)
            ->byToken($token)
            ->notExpired()
            ->one();
//var_dump($userToken);
        if (!$userToken) {
            return ['status'=>1, 'message'=>['验证码无效。']];
        }else{
            return ['status'=>0, 'message'=>['验证码有效。']];
        }
    }

    /**
     * @SWG\POST(path="/sign-in/activation-by-phone",
     *     tags={"100-SignIn-用户接口"},
     *     summary="验证码用户激活[已经自测]",
     *     description="激活用户状态user.status",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "token",
     *        description = "验证码",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "password",
     *        description = "需要修改的明文密码，可选参数",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "用户激活成功"
     *     )
     * )
     *
     */
    /**
     * 验证码用户激活
     * @return string|Response
     */
    public function actionActivationByPhone()
    {
        $token = Yii::$app->request->post('token',0);
        $password = Yii::$app->request->post('password',null);
        $userToken = UserToken::find()
            ->byType(UserToken::TYPE_PHONE_SIGNUP)
            ->byToken($token)
            ->notExpired()
            ->one();
//var_dump($userToken);  exit();
        if (!$userToken) {
            //throw new BadRequestHttpException;
            return ['message'=>['验证码无效。']];
        }

        $user = $userToken->user;
        $info = [
            'status' => User::STATUS_ACTIVE,
        ];

        if($user->safety<=1){
            $info['safety'] = $user->safety+2;
        }
        if($password){
            $info['password_hash'] = Yii::$app->getSecurity()->generatePasswordHash($password);
        }

        $user->updateAttributes($info);
        $userToken->delete();
        Yii::$app->getUser()->login($user);
        /*
        return [
            'message' => Yii::t(
                'frontend',
                //Your account has been successfully activated.
                '您的账户已经成功激活。'
            )
        ];
        */
        return $user->attributes;
    }

    /**
     * @SWG\Get(path="/sign-in/reset-by-sms",
     *     tags={"100-SignIn-用户接口"},
     *     summary="验证码发送[待开发]",
     *     description="发送验证码，成功返回验证码与手机号信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "phone_number",
     *        description = "手机号",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "type",
     *        description = "发送验证码类型",
     *        required = true,
     *        type = "string",
     *        enum = {"repasswd", "signup"}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "用户激活成功"
     *     )
     * )
     *
     */
    /**
     * 验证码发送
     * @return string|Response
     */
    public function actionResetBySms($phone_number, $type='signup')
    {
        $code = UserToken::randomCode();
        $instance = new SendSMSMessage();

        \Yii::$app->language = 'zh-CN';
        $user = User::find()->where(['phone_number'=>$phone_number])->one();
        if(!$user){
            return [
                'message'=>[
                    '手机号不存在'
                ]
            ];
        }

        $type =  ($type == 'signup') ? UserToken::TYPE_PHONE_SIGNUP : UserToken::TYPE_PHONE_REPASSWD;

        UserToken::deleteAll([
            'user_id' => $user->id,
            'type' => $type,
        ]);

        
        $token = UserToken::create(
            $user->id,
            $type,
            Time::SECONDS_IN_A_DAY,
            $code
        );

        if($token){ // 发送短信
            $res = $instance->registerCode($user->phone_number,['code' => $code]);
        }

        $info = [
            'message'=>$code.' 验证码',
            'phone'=>$user->phone_number,
            'messageId' => $res,
            'status' => $res ? 0 : 500 ,
        ];

        return $info;
    }

    /**
     * @SWG\Get(path="/sign-in/reset-passwd-by-phone",
     *     tags={"100-SignIn-用户接口"},
     *     summary="验证码修改密码",
     *     description="根据验证码，修改用户密码",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "token",
     *        description = "验证码",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "newpasswd",
     *        description = "新密码",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "用户密码修改成功"
     *     )
     * )
     *
     */
    /**
     * 短信验证修改密码
     * @return string|Response
     */
    public function actionResetPasswdByPhone($token,$newpasswd)
    {
        \Yii::$app->language = 'zh-CN';
        $token = UserToken::find()
            ->byType(UserToken::TYPE_PHONE_REPASSWD)
            ->byToken($token)
            ->notExpired()
            ->one();
        if (!$token) {
            //throw new BadRequestHttpException;
            //Yii::$app->response->statusCode = 422;
            return [
            'errorno'=>'1',
            'message'=>'验证码不存在'
            ];
        }

        $user = $token->user;
        $info = [
            'status' => User::STATUS_ACTIVE,
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash($newpasswd)
        ];
        if($user->safety<=1){
            $info['safety'] = $user->safety+2;
        }
        $user->updateAttributes($info);
        $token->delete();
        Yii::$app->getUser()->login($user);
        return [
            'errorno' => '0',
            'message' => Yii::t(
                'frontend', 
               // 'Your account has been successfully activated.'
               '您的密码修改成功'
            )
        ];
        return $user->attributes;
    }




    /**
     * @SWG\POST(path="/sign-in/update-profile",
     *     tags={"100-SignIn-用户接口"},
     *     summary="更新用户附属信息",
     *     description="更新用户附属表信息 http://developer.qiniu.com/docs/v6/sdk/ios-sdk.html",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "user_id",
     *        description = "用户ID",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "json_data",
     *        description = "七牛返回的JSON数据",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "头像修改成功"
     *     )
     * )
     *
     */
    //http://developer.qiniu.com/docs/v6/sdk/ios-sdk.html
    /*
    'yajol-static' => [
                'access_key' => 'tNgzEqpaQzZfGFJUln_9u6c7YkpFpPqFeD0zqf6_',
                'secret_key' => 'EmYNea7hf5yB4gwD7NPCR5qwbhMeKWwE38B4OTKn',
                'domain' => 'http://7xrpkx.com1.z0.glb.clouddn.com/',
                'bucket' => 'yajol-static'
            ],
    */
    /*
    {"name":"header.jpg","size":203100,"type":"image\/jpeg","hash":"FoTl-Zw-aJehckIRja4u_KHmGtYi","key":"1470045842510.jpg"}

     */
    public function actionUpdateProfile()
    {
        $avatar_base_url = 'http://7xrpkx.com1.z0.glb.clouddn.com/';
        $avatar_base_url = \Yii::$app->params['qiniu']['static-v1']['domain'];
        $user_id = Yii::$app->request->post('user_id');
        $data = Yii::$app->request->post('json_data');
        $data = json_decode($data, true);
        //$user_id = 0;
        if(empty($user_id)){
            return [];
        }

        $model = UserProfile::findOne($user_id);
        if($model){ // 更新
            $key = $model->avatar_path;
            if($key != $data['key']){
                $auth = new Auth(
                    \Yii::$app->params['qiniu']['static-v1']['access_key'], 
                    \Yii::$app->params['qiniu']['static-v1']['secret_key']
                );
                $bucketMgr = new BucketManager($auth);
                $bucket = \Yii::$app->params['qiniu']['static-v1']['bucket'];
                $key = $model->avatar_path;
                $err = $bucketMgr->delete($bucket, $key);
//var_dump($err); exit();
            }
            $model->avatar_base_url = $avatar_base_url;
            $model->avatar_path = $data['key'];
            $model->save(false);
        }else{ // 创建
            $model = new UserProfile();
            $model->user_id = $user_id;
            $model->avatar_base_url = $avatar_base_url;
            $model->avatar_path = $data['key'];
            $model->save(false);
        }

        return $model->attributes;
    }

     

    /**
     * @SWG\Get(path="/sign-in/qiniu-token",
     *     tags={"100-SignIn-用户接口"},
     *     summary="获取七牛云Token",
     *     description="返回七牛云上传Token",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回Token"
     *     )
     * )
     *
     */
    public function actionQiniuToken()
    {
        $auth = new Auth(
            \Yii::$app->params['qiniu']['static-v1']['access_key'], 
            \Yii::$app->params['qiniu']['static-v1']['secret_key']
        );

        $policy['returnBody'] = '{"name": $(fname),"size": $(fsize),"type": $(mimeType),"hash": $(etag),"key":$(key)}';

        $token = $auth->uploadToken(
            \Yii::$app->params['qiniu']['static-v1']['bucket'],
            null,
            3600,
            $policy
        );

        Yii::$app->response->format = Response::FORMAT_JSON;
        
        Yii::$app->response->data = [
            'uptoken' => $token,
            'domain' => \Yii::$app->params['qiniu']['static-v1']['domain'],
            'bucket' => \Yii::$app->params['qiniu']['static-v1']['bucket'],
        ]; 
        //echo '{"uptoken": "'.$token.'"}';
    }


    /**
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actiolAuthKey()
    {
        $model = new LoginForm;
        if($model->load(\Yii::$app->getRequest()) && $model->login()){
            echo \Yii::$app->user->indentity->getAuthKey();
        }
    }
        
}
