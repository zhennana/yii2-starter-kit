<?php
namespace frontend\modules\api\v1\controllers;

use Yii;
use yii\web\Response;
use frontend\modules\api\v1\resources\Article;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\helpers\Url;

use \backend\modules\campus\models\Notice;

/**
 *
 * Class DeveloperController
 * index.php?r=api/v1/developer
 * curl -i -H 'Accept:application/json' 'http://home.yajol.com/index.php?r=api/v1/article/'
 * curl -i -H 'Accept:application/xml' 'http://home.yajol.com/index.php?r=api/v1/article/'
 *
 * X-Pagination-Total-Count: 数据项总数；
 * X-Pagination-Page-Count: 页面总数；
 * X-Pagination-Current-Page: 当前页面（基于1）；
 * X-Pagination-Per-Page: 每页数据项数目；
 * Link: 允许用户对资源数据进行页面遍历的一系列导航链接。
 * @author Bruce Niu <bruce.bnu@gmail.com>
 */
class ConfigController extends \yii\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\modules\api\v1\resources\Article';
   
    public function beforeAction($action)
    {
    	//\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	//Yii::$app->controller->detachBehavior('access');
    	return $action;
    }


    /**
     * @var array
     */
    /*public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];*/

	/*
	public function behaviors()
	{
	    return [
	        'access' => [
	            'class' => \yii\filters\AccessControl::className(),
	            'rules' => [
	                [
	                    'allow' => true,
	                    'roles' => ['@','?'],
	                ],
	            ],
	            'denyCallback' => function ($rule, $action) {
	                throw new \yii\web\ForbiddenHttpException('aaaaaaaaaaaaaaaaaaa');
	            }
	        ],
	    ];
	}
	*/
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [],
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel' => [$this, 'findModel']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        return new ActiveDataProvider(array(
            'query' => Article::find()->published()
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = Article::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
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
        $info = [];
        $info['cache_stamp'] = strtotime('2010-08-15 21:00:00');
        $info['cache'] = false;

        if($time_stamp == $info['cache_stamp']){
            $info['cache'] = true;
        }

        $info['do_business'] = [
            'active' => 'open', // close and open
            'tips' => '系统维护中。请您谅解，紧急联系方式：400-400-40000',
            'call_up' => '400-400-40000',
        ];

        // 手动配置
        $info['update']['ios'] = [
            // APP store 审核，
            // 0 关闭不提示；
            // 1 打开提示更新
            'show_upgrade_status' => '1',

            'updated_version'   => '2.58.2', // 手动填写

            // 为真显示强制更新 0.不强制更新；1.强制更新; 
            'forced_updating'   => '1', // 1慎用
            
            'server_version'    => $server_version,
            'client_version'    => $client_version,
            
            // 服务端维护范围
            'range_server_version' => [
                '1.1'
            ],

            // ios上线配置
            'description'       => "更新描述：\r\n新增了QQ分享，修复了已知bug",


            // ios安装地址
            'install_address'   => 'https://itunes.apple.com/cn/app/yan-jiao-zai-xian/id1055400570?mt=8',
            'tip'       => '更新失败，请去应用商店或官网直接下载安装',
            // 客户端维护范围
            'range_client_version' => [
                '2.58.2', // 9.1
            ],
            // ios上线配置完
        ];

        $info['update']['android'] = [
             // 是否有新版本更新提示：1：有新版本提示框；0没有；
            'show_upgrade_status' => '1',

             //'version_code' => '', // 安卓特有，CRM数据库字段支持
            'updated_version'   => '2.52', // 2.44

            // 强制更新
            // 为真显示强制更新 0.不强制更新；1.强制更新; 
            'forced_updating'   => '1', 

            
            'server_version'    => $server_version,
            'client_version'    => $client_version,
            

            // 安卓上线配置
            'description'       => "更新描述：\r\n新增了QQ分享，修复了已知bug",

            

            // svn 版本号： 2801 10-31 17:57
            'install_address'   => 'http://7xsm8j.com2.z0.glb.qiniucdn.com/yajol_v2.52_2016-12-21_anzhi_252_1_360_sign.apk',
            
        ];

        return $info;
    }

    /**
     * @SWG\Get(path="/config/default-avatar",
     *     tags={"800-Config-配置信息接口"},
     *     summary="获取默认头像",
     *     description="返回默认头像地址信息",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回默认头像地址信息"
     *     ),
     * )
     *
    **/
    public function actionDefaultAvatar()
    {
        $data = [
            'male' => [
                [
                    'avatar_path' => 'http://omsqlyn5t.bkt.clouddn.com/',
                    'avatar_base_url' => 'touxiang_04.png',
                ],
                [
                    'avatar_path' => 'http://omsqlyn5t.bkt.clouddn.com/',
                    'avatar_base_url' => 'touxiang_03.png',
                ],
            ],

            'female' => [
                [
                    'avatar_path' => 'http://omsqlyn5t.bkt.clouddn.com/',
                    'avatar_base_url' => 'touxiang_05.png',
                ],
                [
                    'avatar_path' => 'http://omsqlyn5t.bkt.clouddn.com/',
                    'avatar_base_url' => 'touxiang_06.png',
                ],
            ],

        ];
        return $data;
    }

    /**
     * @SWG\Get(path="/config/vip-card",
     *     tags={"800-Config-配置信息接口"},
     *     summary="获取延长卡价格与描述",
     *     description="返回延长卡价格与描述",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回延长卡价格与描述"
     *     ),
     * )
     *
    **/
    public function actionVipCard()
    {
        // if (Yii::$app->user->isGuest) {
        //     return [
        //         'errno'=> 203,
        //         'message'=>'请先登录',
        //     ];
        // }

        $params = $temp = $data = [];
        $params = Yii::$app->params['shuo']['card_type'];
        foreach ($params as $key => $value) {
            $temp = $value;
            $temp['type'] = $key;
            $data[] = $temp;
        }

        return [
            'errno'=> 0,
            'message'=>'OK',
            'result' => $data
        ];
    }

     /**
     * @SWG\Post(path="/config/list-notices",
     *     tags={"800-Config-配置信息接口"},
     *     summary="用户反馈通知列表",
     *     description="返回主视觉信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "user_id",
     *        description = "用户ID",
     *        required = true,
     *        default = 1,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加用户反馈"
     *     ),
     * )
     *
    **/
    public function actionListNotices(){
        if(isset(Yii::$app->user->identity->id)){
            $user = Yii::$app->user->identity->attributes;
            //var_dump($user);exit;
        }else{
            return [
                'errorno'=> 203,
                'message'=>'请先登录',
            ];
        }
        //var_dump($user['id']);exit;
        $model = Notice::find();
        $model->andwhere([
            'receiver_id'=>$user['id'], 
            'category'=>Notice::CATEGORY_THREE
            ]);
        //var_dump();exit;

        //获取已回复的问题答案
        $answers = $model
                ->with('question')
                ->asArray()
                ->limit(10)
                ->orderBy(['updated_at'=>SORT_DESC])
                ->all();
// var_dump($answers);exit;
        $answers_count = $model->andwhere([
            'status_check'=>Notice::STATUS_CHECK_NOT_LOOK
            ])
        ->count('notice_id');
        //$data = [];
        $data = [
            'news_notices_numbers' => isset($answers_count)? $answers_count : 0,
            'notices'              => [],
            'userinfo' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'phone_number' => $user['phone_number'],
            ],
        ];
        foreach ($answers as $key => $value) {
            $data['notices'][$key]=[
                    'questions'=>isset($value['question']['message']) ?$value['question']['message'] : '',
                    'answers'  => isset($value['message'])? $value['message'] : '',
            ];
        }
        return $data;
    }

    /**
     * @SWG\Post(path="/config/add-notices",
     *     tags={"800-Config-配置信息接口"},
     *     summary="添加用户反馈",
     *     description="返回主视觉信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "user_id",
     *        description = "用户ID",
     *        required = true,
     *        default = 1,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "message",
     *        description = "用户反馈内容",
     *        required = true,
     *        default = "特别卡，网速慢，改如何解决？",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加用户反馈"
     *     ),
     * )
     *
    **/
    public function actionAddNotices(){
        $model = new Notice;
        $data = [];
        $data['sender_id']         = Yii::$app->request->post('user_id', 0);
        $data['message']           = Yii::$app->request->post('message', '');
        $data['message_hash']      = md5($data['message']);
        $data['school_id']         = 0;
        $data['category']          = Notice::CATEGORY_THREE;
        $data['status_send']       = Notice::STATUS_SEND_SENT;
        $data['status_check']       = Notice::STATUS_CHECK_NOT_LOOK;
        $model->load($data,'');
        $model->save();
        return $model;

    }

    public function actionFeedback(){
        $data = [
            'errorno' => '0',
            'errors'  => '',
        ];
        /*
        if(Yii::$app->user->isGuest){
            $data['errorno']  = __LINE__;
            $data['errors']   = '用户没有登录';
            return $data;
        }

        if(!isset($_POST['content']) && empty($_POST['content'])){
            $data['errorno']  = __LINE__;
            $data['errors']   = '反馈内容不能为空';
            return $data;
        }

        if(!isset($_POST['client_source_type']) && empty($_POST['client_source_type'])){
            $data['errorno']  = __LINE__;
            $data['errors']   = '反馈类型不能为空';
            return $data;
        }
 
        $feedback = new Feedback;
        //$feedback->setattribute = null;
        $feedback->feedback_rater     = Yii::$app->user->identity->id;
        $feedback->content            = $_POST['content'];
        $feedback->client_source_type = $_POST['client_source_type'];
        if(!$feedback->save()){
            $data['errorno'] = __LINE__;
            $data['errors']  = $feedback->getErrors();
        }*/

        return $data;
    }

}