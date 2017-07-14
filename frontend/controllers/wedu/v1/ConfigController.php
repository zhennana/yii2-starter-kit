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
use frontend\models\edu\resources\Course;
use frontend\models\edu\resources\UsersToUsers;
use frontend\models\edu\resources\Courseware;
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
    *     tags={"800-Config-配置信息接口"},
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
     *     tags={"800-Config-配置信息接口"},
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
     *     tags={"800-Config-配置信息接口"},
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
     *     tags={"800-Config-配置信息接口"},
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
     *     tags={"800-Config-配置信息接口"},
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
   //var_dump($notice->message(Notice::CATEGORY_ONE,$school_id,$grade_id));exit;
        $data['message']                   = array_merge($data['message'],$notice->message(Notice::CATEGORY_ONE,$school_id,$grade_id));
        $data['teacher_said']              = array_merge($data['teacher_said'],$notice->message(Notice::CATEGORY_TWO));
        $data['course_item_order']         = array_merge($data['course_item_order'],$course_order->statistical());
        $data['above_course']['title']     = isset($student_record['course']['intro']) ? $student_record['course']['intro']: '';
        $data['my_photos']                 = $my_photos->image_merge(3);
        return $data;
    }

    /**
     * @SWG\Get(path="/config/working-state",
     *     tags={"800-Config-配置信息接口"},
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