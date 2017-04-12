<?php
namespace frontend\controllers\edu;

use Yii;
use yii\web\Response;
use frontend\modules\api\v1\resources\Article;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;


class ConfigController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\Article';

    /**
     * @var array
     */
    public $serializer = [
        'class' => 'common\rest\Serializer',    // 返回格式数据化字段
        'collectionEnvelope' => 'result',       // 制定数据字段名称
        'errno' => 0,                           // 错误处理数字
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


    /**
     * @SWG\Get(path="/config/init",
     *     tags={"800-Config-配置信息接口"},
     *     summary="初始化",
     *     description="返回主视觉信息",
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
                'show_upgrade_status' => '1',

                // 更新版本号
                'updated_version'   => '2.58.2', // 手动填写

                // 强制更新(开启慎用)： 0 关闭 | 1 开启 
                'forced_updating'   => '1',
                
                // 服务端版本号
                'server_version'    => $server_version,

                // 客户端版本号
                'client_version'    => $client_version,
                
                // 服务端维护范围
                'range_server_version' => ['1.1'],

                /** ios上线配置 start **/
                // 更新描述
                'description' => "更新描述",

                // 安装地址
                'install_address' => 'https://itunes.apple.com/cn/app/',
                'tip'             => '更新失败，请去应用商店或官网直接下载安装',

                // 客户端维护范围
                'range_client_version' => [
                    '2.58.2', // 9.1
                ],
                /** ios上线配置 end **/
            ],
            'android' => [
                 // 更新提示：0 关闭 | 1 开启
                'show_upgrade_status' => '1',

                // 安卓特有，CRM数据库字段支持
                // 'version_code' => '',
                 
                // 更新版本号
                'updated_version' => '2.52', // 2.44

                // 强制更新(开启慎用)： 0 关闭 | 1 开启 
                'forced_updating' => '1', 

                // 服务端版本号
                'server_version' => $server_version,

                // 客户端版本号
                'client_version' => $client_version,
                

                /** 安卓上线配置 start **/
                'description' => "更新描述",

                // svn 版本号： 2801 10-31 17:57
                // 安装地址
                'install_address' => 'http://7xsm8j.com2.z0.glb.qiniucdn.com',
                'tip'             => '更新失败，请去应用商店或官网直接下载安装',

                /** 安卓上线配置 end **/
                
            ],
        ];
        return $info;
    }

    /**
     * @SWG\Get(path="/config/banner",
     *     tags={"800-Config-配置信息接口"},
     *     summary="主视觉",
     *     description="返回主视觉信息",
     *     produces={"application/json"},
     *
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "banner_id",
     *        description = "Banner ID",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回主视觉"
     *     ),
     * )
     *
    **/
    /**
     * [actionBanner description]
     * @param  string $banner_id [description]
     * @return [banner_id]            [Banner ID]
     * @return [banner_type]          [Banner类型]
     * @return [banner_caption]       [Banner标题]
     * @return [banner_imgUrl]        [Banner图片地址]
     * @return [banner_target]        [Banner跳转链接]
     */
    public function actionBanner($banner_id='1,2,3,4,5,6')
    {
        $data = [
            [
                'banner_id'      => 1,
                'banner_type'    => 'url',
                'banner_caption' => "Banner_01",
                'banner_imgUrl'  => "",
                'banner_target'  => "",
            ],
            [
                'banner_id'      => 2,
                'banner_type'    => 'url',
                'banner_caption' => "Banner_02",
                'banner_imgUrl'  => "",
                'banner_target'  => "",
            ],
        ];
        return $data;
    }

    /**
     * @SWG\Get(path="/config/button",
     *     tags={"800-Config-配置信息接口"},
     *     summary="按钮",
     *     description="返回主视觉信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "button_id",
     *        description = "按钮ID",
     *        required = false,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回按钮配置值"
     *     ),
     * )
     *
    **/
    /**
     * 首页按钮
     * @return [button_id]       [首页按钮ID]
     * @return [button_type]     [按钮类型，用于区别HTTP或APP原生跳转使用]
     * @return [button_icon]     ['首页按钮图标']
     * @return [button_name]     ['首页按钮名称']
     * @return [button_sort]     ['首页按钮排序']
     * @return [button_target]   ['首页按钮跳转链接']
     */
    public function actionButton($button_id='1,2,3,4,5,6,7,8,9,10')
    {
        $data = [
            [
                'button_id'     => 1,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '走进光大',
                'button_sort'   => '1', // 底部按钮顺序
                'button_target' => '',// Yii::$app->request->hostInfo.Url::to(['store/store-category']),
            ],
            [
                'button_id'     => 2,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '小学部',
                'button_sort'   => '2',
                'button_target' => '',
            ],
            [
                'button_id'     => 3,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '中学部',
                'button_sort'   => '3',
                'button_target' => '',
            ],
            [
                'button_id'     => 4,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '国际部',
                'button_sort'   => '4',
                'button_target' => '',
            ],
            [
                'button_id'     => 5,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '特长部',
                'button_sort'   => '5',
                'button_target' => '',
            ],
            [
                'button_id'     => 6,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '教育教学',
                'button_sort'   => '6',
                'button_target' => '',
            ],
            [
                'button_id'     => 7,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '海外游学',
                'button_sort'   => '7',
                'button_target' => '',
            ],
            [
                'button_id'     => 8,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '招生专栏',
                'button_sort'   => '8',
                'button_target' => '',
            ],
            [
                'button_id'     => 9,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '招贤纳士',
                'button_sort'   => '9',
                'button_target' => '',
            ],
            [
                'button_id'     => 10,
                'button_type'   => '',
                'button_icon'   => '',
                'button_name'   => '在线报名',
                'button_sort'   => '10',
                'button_target' => '',
            ],
        ];
        return $data;
    }


}