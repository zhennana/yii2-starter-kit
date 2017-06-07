<?php
namespace frontend\controllers\gedu\v1;

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

class MyController extends \common\rest\Controller
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
     * @SWG\Get(path="/my/my-course",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的课程",
     *     description="返回我的课程列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyCourse()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        return [];
    }

    /**
     * @SWG\Get(path="/my/my-notice",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的消息",
     *     description="返回我的消息列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyNotice()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $data  = [];
        $model = Notice::find()->where([
            'receiver_id' => Yii::$app->user->identity->id,
            'status_send' => Notice::STATUS_SEND_SENT
        ])->asArray()->all();

        if ($model) {
            foreach ($model as $key => $value) {
                $value['sender_name']   = Notice::getUserName($value['sender_id']);
                $value['receiver_name'] = Notice::getUserName($value['receiver_id']);
                $data[] = $value;
            }
        }

        return $data;
    }

    /**
     * @SWG\Get(path="/my/my-score",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的成绩",
     *     description="返回我的成绩列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyScore()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $data   = [];
        $course = [];
        $temp   = [];

        $course = [
            [
                'course_name' => '语文',
                'midterm' => [
                    'score' => 98,
                    'files' => [
                        [
                            'file_id'  => 1,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35c9jt1h3qcpr1via1lf62qve.png'
                        ],
                        [
                            'file_id'  => 2,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35cueh14i216941t4m2gr1e439.jpg'
                        ],
                        [
                            'file_id'  => 3,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bdaq9i2n1pqr1a3k9uu1vd3cric.jpg'
                        ],
                    ],
                ],
                'final_term' => [
                    'score' => 95,
                    'files' => [
                        [
                            'file_id'  => 1,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35c9jt1h3qcpr1via1lf62qve.png'
                        ],
                        [
                            'file_id'  => 2,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35cueh14i216941t4m2gr1e439.jpg'
                        ],
                        [
                            'file_id'  => 3,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bdaq9i2n1pqr1a3k9uu1vd3cric.jpg'
                        ],
                    ],
                ],
            ],
            [
                'course_name' => '数学',
                'midterm' => [
                    'score' => 91,
                    'files' => [
                        [
                            'file_id'  => 1,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35c9jt1h3qcpr1via1lf62qve.png'
                        ],
                        [
                            'file_id'  => 2,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35cueh14i216941t4m2gr1e439.jpg'
                        ],
                        [
                            'file_id'  => 3,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bdaq9i2n1pqr1a3k9uu1vd3cric.jpg'
                        ],
                    ],
                ],
                'final_term' => [
                    'score' => 96,
                    'files' => [
                        [
                            'file_id'  => 1,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35c9jt1h3qcpr1via1lf62qve.png'
                        ],
                        [
                            'file_id'  => 2,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bd35cueh14i216941t4m2gr1e439.jpg'
                        ],
                        [
                            'file_id'  => 3,
                            'file_url' => 'http://static.v1.wakooedu.com/o_1bdaq9i2n1pqr1a3k9uu1vd3cric.jpg'
                        ],
                    ],
                ],
            ],
        ];

        $temp = [
            'grade_name'         => '燕郊在线商学院',
            'owner_id'           => '马云 班主任',
            'graduate'           => '0未毕业；1毕业',
            'time_of_graduation' => '2000 毕业时间：xxxx年表示第几届',
            'time_of_enrollment' => '1999 入学时间: xxxx年',
            'courses'            => $course,
        ];

        for ($i=1; $i < 3; $i++) { 
            $data[] = $temp;
        }

        return $data;
    }

    /**
     * @SWG\Get(path="/my/my-honor",
     *     tags={"700-My-我的页面接口"},
     *     summary="我的荣誉",
     *     description="返回我的荣誉列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionMyHonor()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $data  = [];
        $temp  = [];

        $title = [
            1 => '再来一瓶幸运奖',
            2 => 'YJZX LOL世界总冠军',
            3 => '书法大赛一等奖',
        ];
        $detail = [
            1 => '康师傅冰红茶再来一瓶奖',
            2 => '第一届YJZX英雄联盟比赛世界总冠军',
            3 => '第一三五七届全国书法大赛一等奖',
        ];

        $rewardsbureau = [
            1 => 'O2O社区超市第10086店',
            2 => '三河市物联网络技术研发有限公司',
            3 => '中国书法爱好者协会',
        ];

        for ($i=1; $i < 4; $i++) { 
            $temp['honor_id']      = $i; 
            $temp['owner_id']      = Yii::$app->user->identity->id;
            $temp['owner']         = Yii::$app->user->identity->username;
            $temp['honor_name']    = $title[$i];
            $temp['honor_detial']  = $detail[$i];
            $temp['rewardsbureau'] = $rewardsbureau[$i];
            $temp['issue_date']    = time();

            $data[] = $temp;
            $temp   = [];
        }

        return $data;
    }


}