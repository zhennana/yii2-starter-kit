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
use frontend\modules\api\v1\resources\Article;
use frontend\models\edu\resources\Course;
use frontend\models\edu\resources\UsersToUsers;
use frontend\models\edu\resources\Courseware;
use frontend\models\edu\resources\Contact;

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
         return $model->streamData();
        /*
        for ($i=1; $i < 4; $i++) {
            $recommend_items[] = [
                'coursee_id'     => (string)$i,
                'type'   => 'image',
                'title'       => '育综合性人才，建四化学校',
                'target_url' => Yii::$app->request->hostInfo.Url::to(['api/courseware/view','id'=>1]),
                'imgUrl'      => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajolyajol_activity_banner_01.png?imageView2/1/w/640/h/282',
            ];
        } 
        for ($i=1; $i < 5; $i++) {
            $recommend_items1[] = [
                'coursee_id'     => (string)$i,
                'type'   => 'video',
                'title'       => '育综合性人才，建四化学校',
                'target_url' => Yii::$app->request->hostInfo.Url::to(['api/courseware/view','id'=>1]),
                'imgUrl'      => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajolyajol_activity_banner_01.png?imageView2/1/w/200/h/100',
            ];
        }


        $data = [
            [
                'type'     => '3',
                'name'     => '精品课程',
                'target_url'=> '这里是更多的跳转',
                'items'    => $recommend_items,
            ],
            [
                'type'     => '4',
                'name'     => '精选课程',
                'target_url'=> '这里是更多的跳转',
                'items'    => $recommend_items1,
            ]];*/
        
        return $data;
    }

    /**
     * @SWG\Get(path="/config/init",
     *     tags={"GEDU-Config-配置信息接口"},
     *     summary="初始化",
     *     description="返回更新版本信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "user_id",
     *        description = "用户ID",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "server_version",
     *        description = "服务端版本（奇数测试版本，偶数为正式版本）",
     *        required = false,
     *        default = "1.0.2",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "client_version",
     *        description = "客户端版本：1.0.2 ; Android/4.5",
     *        required = false,
     *        default = "1.0.2",
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
     *         description = "forced_updating=1,强制更新"
     *     ),
     * )
     *
    **/
    /**
     * 线上版本 2016-08-15
     * IOS 2.24
     * 安卓：2.20
     *
     * 测试版本号
    */
    public function actionInit($user_id=0, $server_version=0, $client_version=0, $time_stamp=0)
    {
        $info        = [];
        $cache       = false;
        $cache_stamp = strtotime('2017-08-15 21:00:00');

        if($time_stamp == $cache_stamp){
            $cache = true;
        }

        $info = [

            // 时间戳
            'cache_stamp' => $cache_stamp,
            'cache'       => $cache,
            /*
            'do_business' => [
                'active'  => 'open',    // close or open
                'tips'    => '系统维护中。请您谅解，紧急联系方式：400-400-40000',
                'call_up' => '400-400-40000',
            ],
            */
            // 手动配置更新信息
            'ios' => [
                // APP store 审核

                // 更新提示：0 关闭 | 1 开启
                'show_upgrade_status' => '更新提示：0 关闭 | 1 开启',

                // 更新版本号
                'updated_version'   => '更新版本号：2.58.2', // 手动填写

                // 强制更新(开启慎用)： 0 关闭 | 1 开启 
                'forced_updating'   => '强制更新(开启慎用)： 0 关闭 | 1 开启',
                
                // 服务端版本号
                'server_version'    => '服务端版本号:'.$server_version,

                // 客户端版本号
                'client_version'    => '客户端版本号:'.$client_version,
                
                // 服务端维护范围
                'range_server_version' => ['服务端维护范围：1.1'],

                /** ios上线配置 start **/
                // 更新描述
                'description' => "更新描述",

                // 安装地址
                'install_address' => '安装地址：https://itunes.apple.com/cn/app/',
                'tip'             => '安装失败提示：更新失败，请去应用商店或官网直接下载安装',

                // 客户端维护范围
                'range_client_version' => [
                    '客户端维护范围：2.58.2', // 9.1
                ],
                /** ios上线配置 end **/
            ],
            'android' => [
                 // 更新提示：0 关闭 | 1 开启
                'show_upgrade_status' => '更新提示：0 关闭 | 1 开启',

                // 安卓特有，CRM数据库字段支持
                // 'version_code' => '',
                 
                // 更新版本号
                'updated_version' => '更新版本号：2.52', // 2.44

                // 强制更新(开启慎用)： 0 关闭 | 1 开启 
                'forced_updating' => '强制更新(开启慎用)： 0 关闭 | 1 开启 ', 

                // 服务端版本号
                'server_version' => '服务端版本号：'.$server_version,

                // 客户端版本号
                'client_version' => '客户端版本号：'.$client_version,
                

                /** 安卓上线配置 start **/
                'description' => "更新描述",

                // svn 版本号： 2801 10-31 17:57
                // 安装地址
                'install_address' => '安装地址：http://7xsm8j.com2.z0.glb.qiniucdn.com',
                'tip'             => '安装失败提示：更新失败，请去应用商店或官网直接下载安装',

                /** 安卓上线配置 end **/
                
            ],
        ];
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
            if($i%2==0){
                $data[$i]['banner_id']  = ''.$i;
                $data[$i]['title']      = $title[$i];
                $data[$i]['imgUrl']     = $img[$i];
                $data[$i]['type']       = 'URL';
                $data[$i]['target_url'] = 'http://www.yajol.com/';
        }else{
                $data[$i]['banner_id']  = ''.$i;
                $data[$i]['title']      = $title[$i];
                $data[$i]['imgUrl']     = $img[$i];
                $data[$i]['type']       = 'APP';
                $data[$i]['target_url'] = Yii::$app->request->hostInfo.Url::to(['gedu/v1/courseware/view','id'=>1]);
        }
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
        $icon = [
            1  => 'http://orh16je38.bkt.clouddn.com/university.png?imageView2/1/w/86/h/86', 
            2  => 'http://orh16je38.bkt.clouddn.com/open-book.png?imageView2/1/w/86/h/86',
            3  => 'http://orh16je38.bkt.clouddn.com/open-book-2.png?imageView2/1/w/86/h/86',
            4  => 'http://orh16je38.bkt.clouddn.com/globe.png?imageView2/1/w/86/h/86',
            5  => 'http://orh16je38.bkt.clouddn.com/diamond.png?imageView2/1/w/86/h/86',
            6  => 'http://orh16je38.bkt.clouddn.com/archive.png?imageView2/1/w/86/h/86',
            7  => 'http://orh16je38.bkt.clouddn.com/graduate.png?imageView2/1/w/86/h/86',
            8  => 'http://orh16je38.bkt.clouddn.com/speech-bubble-4.png?imageView2/1/w/86/h/86',
            9  => 'http://orh16je38.bkt.clouddn.com/brief-case-2.png?imageView2/1/w/86/h/86',
            10 => 'http://orh16je38.bkt.clouddn.com/mouse.png?imageView2/1/w/86/h/86', 
        ];

        $title = [
            1  => '走进光大',
            2  => '小学部',
            3  => '中学部',
            4  => '国际版',
            5  => '特长部',
            6  => '教育教学',
            7  => '海外游学',
            8  => '招生专栏',
            9  => '招贤纳士',
            10 => '在线报名',
        ];

        for ($i=1; $i < 11 ; $i++) {
            $data[$i]['button_id']   = ''. $i;
            $data[$i]['button_type'] = 'URL'; // 类型：url跳转，还是APP内部跳转
            $data[$i]['button_icon'] = $icon[$i] ; // 

            $data[$i]['button_name']   = $title[$i];
            $data[$i]['button_target'] = 'http://www.yajol.com';
        }
        sort($data);
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

}