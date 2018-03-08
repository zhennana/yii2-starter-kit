<?php
namespace frontend\controllers\gedu\v1;

use Yii;

use yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use frontend\models\gedu\resources\Course;
use frontend\models\gedu\resources\UsersToUsers;
use frontend\models\gedu\resources\Courseware;
use frontend\models\gedu\resources\CourseOrderItem;
use frontend\models\gedu\resources\Collect;
use frontend\models\gedu\resources\Notice;
use frontend\models\gedu\resources\User;
use frontend\models\gedu\resources\StudentRecordValue;
use frontend\models\gedu\resources\ContactForm;
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
     * @SWG\Get(path="/my/course",
     *     tags={"GEDU-My-我的页面接口"},
     *     summary="我的课程[静态数据]",
     *     description="返回我的课程列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionCourse()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $model = [];
        $modelClass = new Course;

        /* 
        需要用user_id查询满足如下条件的课程
                已购买    √
                已收藏    √
                已上完   
        */
        // 已收藏课程
        $collect_course = Collect::find()->where([
            'user_id'   => UsersToUsers::getRelevanceGroup(Yii::$app->user->identity->id),
            'status'    => Collect::STATUS_COLLECTED,
            'course_id' => 0
        ])->asArray()->all();
        $collect_course_id = ArrayHelper::getColumn($collect_course, 'course_master_id');

        // 已购买课程
        $order = CourseOrderItem::find()->where([
            'status'         => CourseOrderItem::STATUS_VALID,
            'payment_status' => CourseOrderItem::PAYMENT_STATUS_PAID,
            'user_id'        => UsersToUsers::getRelevanceGroup(Yii::$app->user->identity->id),
        ])->asArray()->all();
        $purchase_course_id = ArrayHelper::getColumn($order, 'course_id');

        $course_id = ArrayHelper::merge($collect_course_id,$purchase_course_id);
        $model = $modelClass::find()
        ->where(['course_id' => $course_id])
            // 状态失效(下架)的课程仅展示
            // ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            // ->andWhere(['category_id' => 14])
            // ->andWhere(['courseware_id' => $modelClass->prentCourseware()])
            ->all();

        return $model;

    }

    /**
     * @SWG\Get(path="/my/notice",
     *     tags={"GEDU-My-我的页面接口"},
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

    public function actionNotice()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        $user = User::findOne(Yii::$app->user->identity->groupId());
        $character_detailes = $user->getCharacterDetailes();

        $data  = [];
        $model = NULL;

        if (isset($character_detailes) && !empty($character_detailes)) {
            $model = Notice::find()
                ->where(['status_send' => Notice::STATUS_SEND_SENT,'type'=>0])
                ->andWhere([
                    'or',

                    // 家校沟通
                    ['receiver_id' => Yii::$app->user->identity->groupId()],
                    [
                        // 学校公告
                        'school_id'   => $character_detailes['school_id'],
                        'grade_id'    => NULL,
                        'receiver_id' => NULL
                    ],
                    [
                        // 班级公告
                        'school_id'   => $character_detailes['school_id'],
                        'grade_id'    => $character_detailes['grade_id'],
                        'receiver_id' => NULL
                    ],
                ])->asArray()->all();
        }

        if ($model) {
            foreach ($model as $key => $value) {
                // $temp['category'] = '';

                // if ($value['grade_id'] == NULL && $value['receiver_id'] == NULL) {
                //     $temp['category']     = '学校公告';
                // }elseif ($value['receiver_id'] == NULL) {
                //     $temp['category']     = '班级公告';
                // }else{
                //     $temp['category']     = '家校沟通';
                // }

                $temp['notice_id']     = $value['notice_id'];
                $temp['school_id']     = $value['school_id'];
                $temp['grade_id']      = $value['grade_id'];
                $temp['type']          = $value['type'];
                $temp['title']         = $value['title'];
                $temp['message']       = $value['message'];
                $temp['sender_id']     = $value['sender_id'];
                $temp['sender_name']   = Notice::getUserName($value['sender_id']);
                $temp['receiver_id']   = $value['receiver_id'];
                $temp['receiver_name'] = Notice::getUserName($value['receiver_id']);
                $temp['status_send']   = $value['status_send'];
                $temp['status_check']  = $value['status_check'];
                $temp['created_at']    = date('Y-m-d H:i:s', $value['created_at']);
                $temp['updated_at']    = date('Y-m-d H:i:s', $value['updated_at']);
                $data[] = $temp;
            }
        }

        return $data;
    }

     /**
     * @SWG\Post(path="/my/notice-check",
     *     tags={"GEDU-My-我的页面接口"},
     *     summary="改变消息查看状态",
     *     description="返回我的消息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "notice_id",
     *        description = "消息ID",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "status_check",
     *        description = "查看状态，10已查看，20未查看",
     *        required = false,
     *        default = 10,
     *        type = "integer",
     *        enum = {10,20}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回我的消息"
     *     ),
     * )
     *
    **/
     public function actionNoticeCheck($notice_id, $status_check = 10)
     {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        if ($status_check != Notice::STATUS_CHECK_LOOK && $status_check != Notice::STATUS_CHECK_NOT_LOOK) {
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '状态参数错误';
            return [];
        }
        
        $model = Notice::find()->where([
            'notice_id'    => $notice_id,
            // 'receiver_id'  => Yii::$app->user->identity->groupId(),
        ])->one();

        if ($model) {
            if ($model->status_check == $status_check) {
                return $model;
            }
            $info = $model->changeCheckStatus($model);
            return $info;
        }

        $this->serializer['errno']   = 404;
        $this->serializer['message'] = '消息不存在';
        return [];
     }


    /**
     * @SWG\Get(path="/my/grade",
     *     tags={"GEDU-My-我的页面接口"},
     *     summary="我的成绩-返回年级列表",
     *     description="返回我的年级列表",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "无需填写，直接返回数据"
     *     ),
     * )
     *
    **/

    public function actionGrade()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id  : NULL;
        //学生家长共有id.
        $user = UsersToUsers::getRelevanceGroup($user_id);
        $score_list = StudentRecordValue::find()
             ->andwhere(['user_id'=>$user])
             ->andwhere(['status'=>StudentRecordValue::STUDENT_VALUE_STATUS_OPEN])
             ->orderBy(['updated_at'=>SORT_DESC])
             ->groupBy('grade_id')
             ->all();
        $data = [];
        foreach ($score_list as $key => $value) {
            $data[] = $value->toArray(['grade_name','grade_id','target_url']);
        }
      return $data;
      /*
        $grade_name = [
            1 => '燕郊在线商学院一年级',
            2 => '飞翔的小鸟',
            3 => '周思思老师班',
        ];

        $owner_id = [
            1 => '马云',
            2 => '马化腾',
            3 => '马卡洛夫',
        ];


        for ($i=1; $i < 4; $i++) {
            $time = rand(1999,2018);
            $temp = [
                'grade_id'           => $i,
                'grade_name'         => $grade_name[$i],
                'owner_id'           => $owner_id[$i],
                'graduate'           => rand(0,1),
                'time_of_graduation' => $time,
                'time_of_enrollment' => $time-3,
                'target_url'         => Yii::$app->request->hostInfo.Url::to(['gedu/v1/my/score','grade_id' => $i]),
            ];
            $data[] = $temp;
        }
        return $data;*/
    }

    /**
     * @SWG\Get(path="/my/score",
     *     tags={"GEDU-My-我的页面接口"},
     *     summary="我的成绩/或者详情",
     *     description="返回我的课程对应成绩",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "user_id",
     *        description = "用户id",
     *        required = false,
     *        type = "string",
     *        default = "1",
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "年级/班级ID",
     *        required = false,
     *        type = "string",
     *        default = "1",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "不传grade_id,获取成绩班级列表；传grade_id,获取成绩详情"
     *     ),
     * )
     *
    **/
    public function actionScore()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        $user_id = Yii::$app->request->get('user_id');
        $grade_id = Yii::$app->request->get('grade_id');
        if(!$user_id){
            $user_id = isset(Yii::$app->user->identity->id) ? Yii::$app->user->identity->id  : NULL;
        }
        $user = UsersToUsers::getRelevanceGroup($user_id);
        $score = StudentRecordValue::find()
             ->andwhere(['user_id'=>$user])
             ->andwhere(['status'=>StudentRecordValue::STUDENT_VALUE_STATUS_OPEN]);
        if($grade_id){
            $fields = ['score','grade_id','full_mark','course_title','images_url'];
            $score = $score->andWhere(['grade_id'=>$grade_id]);
        }else{
            $fields = ['grade_name','grade_id','target_url'];
            $score = $score->groupBy('grade_id');
        }
        $score = $score->orderBy(['updated_at'=>SORT_DESC])->all();
        $data = [];
        foreach ($score as $key => $value) {
            $data[] = $value->toArray($fields);
        }
      return $data;
      /*
        $data  = $temp   = [];
        $files = $params = [];

        $file_url = [
            1 => 'http://orh16je38.bkt.clouddn.com/%E6%A8%A1%E5%9D%97%E5%9B%9B.png',
            2 => 'http://orh16je38.bkt.clouddn.com/shijuan.jpg',
            3 => 'http://orh16je38.bkt.clouddn.com/%E6%A8%A1%E5%9D%97%E5%9B%9B.png',
            4 => 'http://orh16je38.bkt.clouddn.com/shijuan.jpg',
        ];

        for ($i=1; $i < 5; $i++) { 
            $params = [
                'file_id'  => $i,
                'file_url' => $file_url[$i]
            ];
            $files[] = $params;
        }

        $course_title = [
            1 => '英语十六级',
            2 => '语文小测验',
            3 => '数学期末考试',
            4 => '课堂平时成绩',
            5 => '毕业考综合项目',
        ];

        for ($i=1; $i < 6; $i++) {
            $temp = [
                'course_id'    => $i,
                'course_title' => $course_title[$i],
                'full_mark'    => 100,
                'score'        => rand(50,100),
                'files'        => $files,
            ];
            $data[] = $temp;
        }

        return $data;*/
    }

    /**
     * @SWG\Post(path="/my/send-email",
     *     tags={"GEDU-My-我的页面接口"},
     *     summary="发送邮件",
     *     description="发送邮件",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "email",
     *        description = "我的邮件",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "subject",
     *        description = "邮件主题",
     *        required = false,
     *        default = 0,
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "body",
     *        description = "邮件内容",
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
    public function actionSendEmail(){
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        $model = new ContactForm;
        try{
            if($model->load(Yii::$app->request->post(),'')){
                $model->addCreate();
                return $model;
            }else{
                $model->addError('expire','数据加载失败');
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
        }
        return $model;
    }
    /**
     * @SWG\Get(path="/my/honor",
     *     tags={"GEDU-My-我的页面接口"},
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

    public function actionHonor()
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
        $img = [
            1 => 'http://static.v1.wakooedu.com/o_1bhtk7tba15j71ls81jo9kl85gb9.png',
            2 => 'http://static.v1.wakooedu.com/o_1bhtknjdehqdu42b831f9l164i9.png',
            3 => 'http://static.v1.wakooedu.com/o_1bhtk6b0s1k1qu861u2g1knf1hv9.png',
        ];

        for ($i=1; $i < 4; $i++) { 
            $temp['honor_id']      = $i;
            $temp['owner_id']      = Yii::$app->user->identity->id;
            $temp['owner']         = Yii::$app->user->identity->username;
            $temp['honor_name']    = $title[$i];
            $temp['honor_detial']  = $detail[$i];
            $temp['imgUrl']        = $img[$i];
            $temp['rewardsbureau'] = $rewardsbureau[$i];
            $temp['issue_date']    = time();

            $data[] = $temp;
            $temp   = [];
        }

        return $data;
    }


}