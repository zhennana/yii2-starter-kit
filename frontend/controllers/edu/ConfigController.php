<?php
namespace frontend\controllers\edu;

use Yii;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;

use frontend\modules\api\v1\resources\Article;
use frontend\models\resources\Course;

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
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "user_id",
     *        description = "用户ID，没有登录默认0",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionIndex()
    {

        // 精品课程
        for ($i=0; $i < 4; $i++) { 
            $course_items[] = [
                'course_id'       => '1',
                'course_imgUrl'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajolyajol_activity_banner_01.png?imageView2/1/w/128/h/128',
                'course_title'    => '全脑速记',
                'course_featured' => '精品',

            ];
        }

        // 专题推荐
        for ($i=0; $i < 2; $i++) { 
            $recommend_items[] = [
                'recommend_id'       => '2',
                'recommend_imgUrl'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajolyajol_activity_banner_01.png?imageView2/1/w/128/h/128',
                'recommend_title'    => '育综合性人才，建四化学校',
                'recommend_featured' => '精品',
            ];
        }

        $data = [
            [
                'stream_id'       => '1',
                'stream_type'     => 'APP',
                'stream_name'     => '精品课程',
                'stream_item_sum' => '4',
                'stream_status'   => '1',   // 1表示显示，0表示不显示
                'stream_target'   => 'APP',
                'stream_items'    => $course_items,
            ],
            [
                'stream_id'       => '2',
                'stream_type'     => 'URL',
                'stream_name'     => '专题推荐',
                'stream_item_sum' => '2',
                'stream_status'   => '1',   // 1表示显示，0表示不显示
                'stream_target'   => 'URL',
                'stream_items'    => $recommend_items,
            ],
        ];

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
     * @SWG\Get(path="/config/primary-vision",
     *     tags={"800-Config-配置信息接口"},
     *     summary="主视觉(banner、按钮、按钮下方模块)",
     *     description="返回主视觉信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "type",
     *        description = "选择主视觉类型，默认all",
     *        required = false,
     *        type = "string",
     *        default = "all",
     *        enum = {"all","banner","button","block"}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回主视觉"
     *     ),
     * )
     *
    **/
    /**
     * [actionPrimaryVision description]
     * @param  string $type [description]
     * @return [type]       [description]
     */
    public function actionPrimaryVision($type='all')
    {
        if ($type == 'all' || $type =='banner') {
            $data['banner'] = [
                [
                    'banner_id'      => '1',
                    'banner_type'    => 'url',
                    'banner_caption' => "燕郊在线，服务燕郊人",
                    'banner_imgUrl'  => "http://7xsm8j.com2.z0.glb.qiniucdn.com/yajol.jpg?imageView2/1/w/640/h/282",
                    'banner_target'  => "http://www.yajol.com",
                ],
                [
                    'banner_id'      => '2',
                    'banner_type'    => 'url',
                    'banner_caption' => "社区超市",
                    'banner_imgUrl'  => "http://7xsm8j.com2.z0.glb.qiniucdn.com/O2Omarketbanner.jpg?imageView2/1/w/640/h/282",
                    'banner_target'  => "http://www.yajol.com",
                ],
            ];
        }

        if ($type == 'all' || $type == 'button') {
            $data['button'] = [
                [
                    'button_id'     => '1',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/articles.png',
                    'button_name'   => '走进光大',
                    'button_sort'   => '1',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/view', 'id' => 1]),
                ],
                [
                    'button_id'     => '2',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/vegetable.png',
                    'button_name'   => '小学部',
                    'button_sort'   => '2',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '3',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/chille.png',
                    'button_name'   => '中学部',
                    'button_sort'   => '3',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '4',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/dried_fruit_and_nuts.png',
                    'button_name'   => '国际部',
                    'button_sort'   => '4',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '5',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/wholesale_category.png',
                    'button_name'   => '特长部',
                    'button_sort'   => '5',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '6',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/cigarette_drink.png',
                    'button_name'   => '教育教学',
                    'button_sort'   => '6',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '7',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/snack_food.png',
                    'button_name'   => '海外游学',
                    'button_sort'   => '7',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '8',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/learn.png',
                    'button_name'   => '招生专栏',
                    'button_sort'   => '8',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '9',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/fast-food.png',
                    'button_name'   => '招贤纳士',
                    'button_sort'   => '9',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
                [
                    'button_id'     => '10',
                    'button_type'   => 'url',
                    'button_icon'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/articles.png',
                    'button_name'   => '在线报名',
                    'button_sort'   => '10',
                    'button_target' => Yii::$app->request->hostInfo.Url::to(['article/index']),
                ],
            ];
        }

        if ($type == 'all' || $type == 'block') {
            $data['block'] = [
                [
                    'block_name'   => 'top',
                    'block_title'  => '中国梦，教育梦',
                    'block_target' => Yii::$app->request->hostInfo.Url::to(['article/view', 'id' => 1]),
                    'img_url'      => 'http://7xutvv.com2.z0.glb.qiniucdn.com/o_1b69dmmq11uefuon1e89o181ek5l.jpg',
                ],
                [
                    'block_name'   => 'left',
                    'block_title'  => '教学楼',
                    'block_target' => Yii::$app->request->hostInfo.Url::to(['article/view', 'id' => 1]),
                    'img_url'      => 'http://7xutvv.com2.z0.glb.qiniucdn.com/o_1b663qa4p1a4p1v85hjf1usphgs26.jpg',
                ],
                [
                    'block_name'   => 'right',
                    'block_title'  => '物理实验室',
                    'block_target' => Yii::$app->request->hostInfo.Url::to(['article/view', 'id' => 1]),
                    'img_url'      => 'http://7xutvv.com2.z0.glb.qiniucdn.com/o_1b662vj931cj5sas1uhs1i2m14eo2c.jpg',
                ],
            ];
        }

        return $data;
    }



}