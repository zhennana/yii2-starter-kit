<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;
use common\wechat\JSSDK;
use common\models\ArticleCategory;
use frontend\models\edu\resources\Course;
use frontend\models\edu\resources\UsersToUsers;
use frontend\models\edu\resources\Courseware;
use frontend\models\edu\resources\Contact;
use frontend\models\edu\resources\ApplyToPlay;

class ConfigController extends \common\rest\Controller
{
    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        // 'errno' => 0,                           // 错误处理数字
        'message' => 'OK',                      // 文本提示
    ];

    /**
     * @param  [action] yii\rest\IndexAction
     * @return [type] 
     */
    public function beforeAction($action)
    {
        $format = \Yii::$app->getRequest()->getQueryParam('format', 'json');

        if($format == 'xml'){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        }else{
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }

        // 移除access行为，参数为空全部移除
        // Yii::$app->controller->detachBehavior('access');
        return $action;
    }

    /**
     * @param  [type]
     * @param  [type]
     * @return [type]
     */
    public function afterAction($action, $result){
        $result = parent::afterAction($action, $result);

        return $result;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    /**
     * @SWG\Get(path="/config/index",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="信息流列表",
     *     description="返回首页流",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionIndex()
    {
         $model = new Courseware;
         $params = [
            ['type' => 3, 'name' => '热门课程', 'sort' => [1,2,3]],
            ['type' => 4, 'name' => '精品课程', 'sort' => [4,5,6,7]],
            ['type' => 2, 'name' => '专题推荐', 'sort' => [8,9]],
            ['type' => 4, 'name' => '相关推荐', 'sort' => [10,11,12,13]],
            ['type' => 4, 'name' => '免费课程', 'sort' => [14,15,16,17]],
         ];
         return $model->streamData($params);
    }

    /**
     * @SWG\Get(path="/config/init",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="初始化",
     *     description="返回配置参数",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_type",
     *        description = "客户端类型：1:Android； 2:IOS",
     *        required = false,
     *        default = "Android",
     *        type = "string",
     *        enum = {"Android","IOS"}
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_version",
     *        description = "客户端版本：1.0.3 ; Android/4.5",
     *        required = false,
     *        default = "1.0.3",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "server_version",
     *        description = "服务端版本：1.0.3 ",
     *        required = false,
     *        default = "1.0.3",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "time_stamp",
     *        description = "缓存时间戳",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回配置参数"
     *     ),
     * )
     *
    **/
    /**
     * 线上版本 2017-07-16
     * IOS： 1.02
     * 安卓：1.03
     *
     * 测试版本号
    */
    public function actionInit($client_type = '', $client_version=0, $server_version=0, $time_stamp=0)
    {
        $info = [];

        // 缓存配置
        $info['sys_params'] = [
            'cache_stamp' => strtotime('2010-08-15 21:00:00'),
            'cache'       => false,

        ];
        if($time_stamp == $info['sys_params']['cache_stamp']){
            $info['sys_params']['cache'] = false;
        }

        // 客户端配置
        // 安卓上线配置
        if ($client_type == 'Android') {
            $info['client_params'] = [

                // 安卓客户端当前版本
                'client_version' => $client_version,

                // 安卓客户端最新版本，发版后手动更新为最新版本
                'uptodate_version' => '1.0.1',

                // 字段初始化，不需配置，走更新逻辑
                'show_status'     => '0',   // 更新提示
                'forced_updating' => '0',   // 强制更新

                // 安卓更新描述，发版后手动更新
                'description' => "\r\n修复已知bug\r\n",

                // 安卓特有，CRM数据库字段支持
                // 'version_code' => '', 

                // 安卓安装地址，发版后手动更新
                'install_address' => '',

                // 安卓更新失败提示，发版后手动更新
                'tip' => '更新失败，请去应用商店或官网直接下载安装',

                // 安卓客户端维护范围，在此范围内的版本不会强制更新
                'range_client_version' => [
                    '1.0.0',
                    '1.0.1',
                ],

                // 安卓服务端版本号
                // 'server_version' => $server_version,
                
                // 安卓服务端维护范围
                /*
                'range_server_version' => [
                    '1.0.3'
                ],
                */

            ];
        // 安卓上线配置结束
        
        // IOS上线配置
        }elseif($client_type == 'IOS'){
            $info['client_params'] = [
                // IOS客户端当前版本
                'client_version' => $client_version,
                
                // IOS客户端最新版本，发版后手动更新为最新版本
                'uptodate_version' => '1.0.3', 

                // 字段初始化，不需配置，走更新逻辑
                'show_status'     => '0',   // 更新提示
                'forced_updating' => '0',   // 强制更新

                // IOS更新描述，发版后手动更新
                'description' => "更新内容：\r\n修复已知bug\r\n",

                // IOS安装地址，发版后手动更新
                'install_address' => '',

                // IOS更新失败提示，发版后手动更新
                'tip' => '更新失败，请去应用商店直接下载安装',

                // IOS客户端维护范围，在此范围内的版本不会强制更新
                'range_client_version' => [
                    '1.0.3', 
                ],

                // IOS服务端版本号
                // 'server_version' => $server_version,

                // IOS服务端维护范围
                /*
                'range_server_version' => [
                    '1.0.2'
                ],
                */
            ];
        }
        // IOS上线配置结束
        
        // 更新提示、强制更新逻辑
        if (isset($info['client_params']) && !empty($info['client_params'])) {
            // 更新提示
            // 当前客户端版本与最新发布版本[不同]，则提示更新；反之，则不提示更新；
            if($client_version != $info['client_params']['uptodate_version']){
                $info['client_params']['show_status'] = '1';

                // 强制更新
                // 当前客户端版本[不在]客户端维护范围内，则强制更新；反之，则不强制更新；
                if(!in_array($client_version,$info['client_params']['range_client_version'])){
                    $info['client_params']['forced_updating'] = '1';
                }

                // IOS手动配置开启或关闭更新提示
                if ($client_type == 'IOS') {
                    $info['client_params']['show_status']     = '0';
                    $info['client_params']['forced_updating'] = '0';
                }
            }
        }
        
        return $info;
    }


    /**
     * @SWG\Get(path="/config/banner",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="Banner",
     *     description="返回Banner",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回Banner"
     *     ),
     * )
     *
    **/
    /**
     * [actionPrimaryVision description]
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function actionBanner()
    {
        $img=[
            1 => 'http://orh16je38.bkt.clouddn.com/banner.png',
            2 => 'http://orh16je38.bkt.clouddn.com/banner.png'
        ];
        $title=[
            1 => '直击精品课程',
            2 => '冠军品质，值得信赖'
        ];
        $data = [];
        //var_dump($data);exit();
        for ($i=1; $i < 3 ; $i++) {
            
                // $data[$i]['banner_id']  = ''.$i;
                // $data[$i]['title']      = $title[$i];
                // $data[$i]['imgUrl']     = $img[$i];
                // $data[$i]['type']       = 'URL';
                // $data[$i]['target_url'] = 'http://www.yajol.com/';
        
                $data[$i]['banner_id']  = ''.$i;
                $data[$i]['title']      = $title[$i];
                $data[$i]['imgUrl']     = $img[$i];
                $data[$i]['type']       = 'APP';
                $data[$i]['target_url'] = Yii::$app->request->hostInfo.Url::to(['v1/courseware/view','courseware_id'=>46]);
        
    }
        sort($data);
        return $data;
    }

    /**
     * @SWG\Get(path="/config/button",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="按钮",
     *     description="返回首页按钮",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回首页按钮"
     *     ),
     * )
     *
    **/
    public function actionButton()
    {
        $icons = [
            1=>'http://orh16je38.bkt.clouddn.com/university.png?imageView2/1/w/86/h/86', 
            2=>'http://orh16je38.bkt.clouddn.com/open-book.png?imageView2/1/w/86/h/86',
            3=>'http://orh16je38.bkt.clouddn.com/open-book-2.png?imageView2/1/w/86/h/86',
            4=>'http://orh16je38.bkt.clouddn.com/globe.png?imageView2/1/w/86/h/86',
            5=>'http://orh16je38.bkt.clouddn.com/diamond.png?imageView2/1/w/86/h/86',
            6=>'http://orh16je38.bkt.clouddn.com/archive.png?imageView2/1/w/86/h/86',
            7=>'http://orh16je38.bkt.clouddn.com/graduate.png?imageView2/1/w/86/h/86',
            8=>'http://orh16je38.bkt.clouddn.com/speech-bubble-4.png?imageView2/1/w/86/h/86',
            // 9=>'http://orh16je38.bkt.clouddn.com/brief-case-2.png?imageView2/1/w/86/h/86',
            // 10=>'http://orh16je38.bkt.clouddn.com/mouse.png?imageView2/1/w/86/h/86', 
        ];

        $category = ArticleCategory::find()
            ->where(['parent_id' => null,'status' => ArticleCategory::STATUS_ACTIVE])
            ->andWhere(['NOT',['id' => 46]])
            ->asArray()
            ->all();

        foreach ($category as $key => $value) {
            $temp = [];
            $temp['button_id']     = (string)($key+1);
            $temp['button_type']   = 'APP';
            $temp['button_icon']   = $icons[$key+1];
            $temp['button_name']   = $value['title'];
            $temp['category_id']   = $value['id'];
            $temp['button_target'] = Yii::$app->request->hostInfo.Url::to(['v1/article/list','id'=>$value['id']]);
            $data[] = $temp;
        }

        // 在线报名
        $apply = [];
        $apply['button_id']     = '7';
        $apply['button_type']   = 'FORM';
        $apply['button_icon']   = $icons[7];
        $apply['button_name']   = '在线报名';
        $apply['category_id']   = '';
        $apply['button_target'] = Yii::$app->request->hostInfo.Url::to(['v1/config/apply']);
        array_push($data,$apply);

        // 联系我们
        $contact = [];
        $contact['button_id']     = '8';
        $contact['button_type']   = 'ARTICLE';
        $contact['button_icon']   = $icons[8];
        $contact['button_name']   = '联系我们';
        $contact['category_id']   = '';
        $contact['button_target'] = Yii::$app->request->hostInfo.Url::to(['v1/article/contact']);
        array_push($data,$contact);

        return $data;
    }

    /**
     * @SWG\Get(path="/config/share",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="微信内嵌网页分享",
     *     description="返回首页按钮",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "AppID",
     *        description = "AppID",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "AppSecret",
     *        description = "AppSecret",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "url",
     *        description = "要分享网页的url",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回签名"
     *     ),
     * )
     *
    **/
    public function actionShare($AppID = 'wx1b4d4c528735833c', $AppSecret = '8d6b54b92ede962c2b0a5d0c4b6679a7', $url = '')
    {
        
        if ($url == '') {
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = 'URL不能为空';
            return [];
        }

        if ($AppID == 'wx1b4d4c528735833c' && $AppSecret == '8d6b54b92ede962c2b0a5d0c4b6679a7') {
            $sdk          = new JSSDK($AppID, $AppSecret);
            $sign_package = $sdk->getSignPackage($url);

            if (isset($sign_package->errcode) && isset($sign_package->errmsg)) {
                $this->serializer['errno']   = $sign_package->errcode;
                $this->serializer['message'] = $sign_package->errmsg;
                return [];
            }

            return $sign_package;
        }else{
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '参数错误：AppID或AppSecret';
            return [];
        }
    }

    /**
     * @SWG\Post(path="/config/feedback",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="反馈意见",
     *     description="error= 0 反馈意见成功",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "body",
     *        description = "反馈内容,max=255",
     *        required = true,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "errorno= 0  成功  其他错误"
     *     ),
     * )
     *
    **/
    public function actionFeedback()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        if (isset($_POST['body']) && !empty($_POST['body']) && isset($_POST['school_id']) && !empty($_POST['school_id'])) {
            $count = Contact::find()->where([
                'school_id' => $_POST['school_id'],
                'user_id'   => Yii::$app->user->identity->id,
                'body'      => $_POST['body'],
                // 'status'   => Contact::CONTACT_STATUS_APPROVED
            ])->count();
            if ($count > 0) {
                $this->serializer['message'] = '该问题已经被记录过了';
                return [];
            }
        }

        $feedback = new Contact();
        $feedback->setScenario(Contact::SCENARIO_FEEDBACK);
        $_POST['user_id']      = Yii::$app->user->identity->id;
        $_POST['username']     = Yii::$app->user->identity->username;
        $_POST['phone_number'] = Yii::$app->user->identity->phone_number;
        // var_dump($feedback->load($_POST,''));exit;
        $feedback->load($_POST,'');
        if(!$feedback->save()){
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = $feedback->getErrors();
        }

        return [];
    }

    /**
     * @SWG\Post(path="/config/apply",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="在线报名",
     *     description="在线报名",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "username",
     *        description = "报名人姓名",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "age",
     *        description = "报名人年龄",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "gender",
     *        description = "性别：1男，2女",
     *        required = true,
     *        type = "integer",
     *        enum = {1,2}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "guardian",
     *        description = "监护人",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "phone_number",
     *        description = "报名人电话",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "email",
     *        description = "邮箱",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "birth",
     *        description = "出生年月",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "nation",
     *        description = "民族",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "body",
     *        description = "个人简历",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "address",
     *        description = "详细地址",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "province_id",
     *        description = "省",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "校区",
     *        required = false,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "errorno= 0  成功  其他错误"
     *     ),
     * )
     *
    **/
    public function actionApply()
    {
        $params['ApplyToPlay'] = Yii::$app->request->post();
        $model = new ApplyToPlay;
        if ($model->load($params) && $model->validate()) {
           if ($model->save()) {
               return $model;
           }
        }
        $this->serializer['errno']   = __LINE__;
        $this->serializer['message'] = $model->getErrors();
        return [];
    }

}