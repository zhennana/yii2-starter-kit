<?php
namespace frontend\controllers\wedu\v1;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;
use frontend\modules\api\v1\resources\Article;
use frontend\models\wedu\resources\Course;
//use frontend\models\edu\resources\UsersToUsers;
use frontend\models\gedu\resources\Courseware;
use frontend\models\wedu\resources\Notice;
use frontend\models\wedu\resources\CourseOrderItem;
use frontend\models\wedu\resources\StudentRecord;
use backend\modules\campus\models\WorkRecord;

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
    *     tags={"WEDU-Config-配置信息接口"},
    *     summary="信息流列表",
    *     description="返回首页流",
    *     produces={"application/json"},
    *     @SWG\Response(
    *         response = 200,
    *         description = "无需填写，直接返回数据"
    *     ),
    * )
    *
   */
   
    public function actionIndex()
    {
         //$model = new Courseware;
         //return $model->streamData();
        
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
            ]];
        return $data;
    }


    /**
     * @SWG\Get(path="/config/init",
     *     tags={"WEDU-Config-配置信息接口"},
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
                'description' => "1.修复已知问题\r\n 2.增加消息推送功能",

                // 安卓特有，CRM数据库字段支持
                // 'version_code' => '', 

                // 安卓安装地址，发版后手动更新
                'install_address' => 'http://static.v1.wakooedu.com/app-release-1.0.1.apk',

                // 安卓更新失败提示，发版后手动更新
                'tip' => '更新失败，请去应用商店或官网直接下载安装',

                // 安卓客户端维护范围，在此范围内的版本不会强制更新
                'range_client_version' => [
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
                'install_address' => 'https://itunes.apple.com/cn/app/瓦酷机器人/id1248260732?mt=8',

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
     *     tags={"WEDU-Config-配置信息接口"},
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
            1 => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/573ed468312f3.jpg?imageView2/1/w/640/h/282',
            2 => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/bannerone.jpg?imageView2/1/w/640/h/282'
        ];
        $title=[
            1 => '直击精品课程',
            2 => '冠军品质，值得信赖'
        ];
        $data = [];
        //var_dump($data);exit();
        for ($i=1; $i < 3 ; $i++) {
            if($i%2==0){
                $data[$i]['courseware_id']      = ''.$i;
                $data[$i]['type']    = 'image';
                $data[$i]['title'] = $title[$i];
                $data[$i]['imgUrl']  = $img[$i];
                $data[$i]['target_url']  = Yii::$app->request->hostInfo.Url::to(['api/courseware/view','id'=>1]);
        }else{
                $data[$i]['courseware_id']      = ''.$i;
                $data[$i]['type']    = 'APP';
                $data[$i]['title'] = $title[$i];
                $data[$i]['imgUrl']  = $img[$i];
                $data[$i]['target_url']  = Yii::$app->request->hostInfo.Url::to(['api/courseware/view','id'=>1]);
        }
    }
        sort($data);
        return $data;
    }

    /**
     * @SWG\Get(path="/config/button",
     *     tags={"WEDU-Config-配置信息接口"},
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
            1  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/ShanSong.png?imageView2/1/w/86/h/86', 
            2  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/PiFa.png?imageView2/1/w/86/h/86',
            3  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/miaoshou.jpg?imageView2/1/w/86/h/86',
            4  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/Tel.png?imageView2/1/w/86/h/86',
            5  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/BianMin.png?imageView2/1/w/86/h/86',
            6  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/market.png?imageView2/1/w/86/h/86',
            7  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/shangjia.jpg?imageView2/1/w/86/h/86',
            8  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/chuyou.jpg?imageView2/1/w/86/h/86',
            9  => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/Tel.png?imageView2/1/w/86/h/86',
            10 => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/ShanSong.png?imageView2/1/w/86/h/86', 
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

        for ($i=1; $i < 9 ; $i++) {
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
     * @SWG\Get(path="/config/account",
     *     tags={"WEDU-Config-配置信息接口"},
     *     summary="我的页面",
     *     description="返回通知 老师说的话 课程相关 以上课程 我的照片 关于我们",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "query",
     *        name = "school_id",
     *        description = "学校",
     *        required = false,
     *        default = 1,
     *        type = "integer"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "班级",
     *        required = false,
     *        default = 1,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回通知 老师说的话 课程相关 以上课程 我的照片 关于我们"
     *     ),
     * )
     *
    **/
    public function actionAccount($school_id = NULL,$grade_id = NULL){
        $data = [
             'message'=>['label'=>'通知'],
             'teacher_said'=>['label'=>'老师说的话'],
             'course_item_order'=>['label'=>'课程相关'],
             'above_course'     =>['label'=>'已上课程'],
             'my_photos'        =>['label'=>'我的照片'],
             'about'            =>['label'=>'关于我们']
        ];
        if(isset(Yii::$app->user->identity->id)){
            $user_id = Yii::$app->user->identity->id;
        }else{
            $this->serializer['errno'] = 300;
            $this->serializer['message'] = '请你先登录';
            return [];
        }
        $notice          =    new Notice;
        $course_order    =    new CourseOrderItem;
        $my_photos       =    new StudentRecord;
        $student_record  =  StudentRecord::find()
                            ->where(['user_id'=>$user_id])
                            ->with('course')
                            ->orderBy(['created_at'=>'SORT_SESC'])
                            ->asArray()
                            ->one();
//var_dump($student_record);exit;
    //var_dump($notice->message(Notice::CATEGORY_ONE,$school_id,$grade_id));exit;
        $data['message']                   = array_merge($data['message'],$notice->message(Notice::CATEGORY_ONE,$school_id,$grade_id));
        $data['teacher_said']              = array_merge($data['teacher_said'],$notice->message(Notice::CATEGORY_TWO));
        $data['course_item_order']         = array_merge($data['course_item_order'],$course_order->statistical());
        $data['above_course']['title']     = isset($student_record['course']['title']) ? $student_record['course']['title']: '';
        $data['my_photos']                 = $my_photos->image_merge(3);
        return $data;
    }

    /**
     * @SWG\Get(path="/config/working-state",
     *     tags={"WEDU-Config-配置信息接口"},
     *     summary="老师的工作内容",
     *     description="老师的工作内容",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "老师的工作内容"
     *     ),
     * )
     *
    **/
    /**
     * 老师工作
    */
    public function actionWorkingState(){
        if(isset(Yii::$app->user->identity->id)){
            $user_id = Yii::$app->user->identity->id;
        }else{
            $this->serializer['errno'] = 300;
            $this->serializer['message'] = '请你先登录';
            return [];
        }
          $start = date('Y-m-d').' 00:00:00';
          $end   = date('Y-m-d')." 23:59:59";
          $start = strtotime($start);
          $end   = strtotime($end);
        $notice          = new Notice;
        $work_recourd    =  WorkRecord::find()
                         ->andwhere(['user_id'=>$user_id])
                         ->andwhere(['between','created_at',$start,$end])
                         //->andWhere('between','created_at',$start,$end)
                         ->all();
        $data['message'] = $notice->message(Notice::CATEGORY_ONE);
        $data['working_state'] = [];
        foreach ($work_recourd as $key => $value) {
            if($value->type == 1 ){
                $data['working_state'][0]['title']  = $value['title'];
                if(!isset($data['working_state'][0]['status']) || $data['working_state'][0]['status'] == 10){
                        $data['working_state'][0]['status'] = $value->status;

                }
            }
            if($value->type == 2){
                $data['working_state'][1]['title']  = $value['title'];
              if(!isset($data['working_state'][1]['status']) || $data['working_state'][0]['status'] == 10){
                        $data['working_state'][1]['status'] = $value->status;

                }
            }
            if($value->type == 4){
                $data['working_state'][2]['title']  = $value['title'];
                 if(!isset($data['working_state'][2]['status']) || $data['working_state'][0]['status'] == 10){
                        $data['working_state'][2]['status'] = $value->status;

                }
            }
        }
        sort($data['working_state']);
        return $data;
    }
}