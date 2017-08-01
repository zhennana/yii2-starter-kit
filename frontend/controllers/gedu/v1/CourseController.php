<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use frontend\models\edu\resources\Collect;


class CourseController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\edu\resources\Course';

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

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
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
     * @SWG\Get(path="/course/list",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="课程列表",
     *     description="根据课程子分类ID返回主课程列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "课程子分类ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "根据程子分类ID返回主课程列表"
     *     )
     * )
     *
    **/
    public function actionList($category_id)
    {
        $modelClass = new $this->modelClass;
        return $modelClass->courseListFormat($category_id);
    }

    /**
     * @SWG\Get(path="/course/view",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="课程详情",
     *     description="根据主课程ID获取主课程及下属子课程相关数据",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "course_id",
     *        description = "主课程ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "根据程子分类ID返回主课程列表"
     *     )
     * )
     *
    **/
    public function actionView($course_id)
    {
        $data = [];
        $modelClass = new $this->modelClass;

        // 查询主课程
        $model = $modelClass::find()->where([
            'course_id' => $course_id,
            'parent_id' => 0,
            'status'    => $modelClass::COURSE_STATUS_OPEN
        ])->one();

        if (!$model) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'master course is not exist.';
            return [];
        }

        // 获取子课程相关数据，并格式化

        return $model->getSubjectsByApi();

    }

    /**
     * @SWG\Get(path="/course/hot-words",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="热词",
     *     description="返回课程搜索词",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "limit",
     *        description = "个数",
     *        required = false,
     *        default = 20,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "success"
     *     ),
     * )
     *
     */
    public function actionHotWords($limit = 20)
    {
        $temp = [];
        $data = [];

        $keywords = [
            '爱乐奇','全脑','牛津','英语','小学','幼儿','胎教音乐','出国留学','English','脑部开发','学前','歌曲','儿童','阿尔法','单词','出国','留学','哈佛','英语四级','发音',
        ];

        if ($limit < 1) {
            $limit = 1;
        }
        if ($limit > 20) {
            $limit = 20;
        }

        for ($i=0; $i < $limit; $i++) {
            $temp['keywords']     = $keywords[$i];
            $temp['trend_counts'] = rand(1000,5000);                         // 搜索次数
            $temp['updated_at']   = time()-rand(100000,500000);              // 更新时间
            $data[] = $temp;
        }

        /*
        return SearchHotKeyword::find()->select([
            'keywords',
            'trend_counts',
            'sku_count',
        ])
        ->orderBy('trend_counts DESC,sku_count DESC,updated_at DESC')
        ->limit($limit)
        ->all();
        */
       ArrayHelper::multisort($data,'trend_counts',SORT_DESC);
       return $data;
    }

    /**
     * @SWG\Get(path="/course/search",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="搜索主课程",
     *     description="返回主课程列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "keyword",
     *        description = "关键词",
     *        required = false,
     *        default = "1",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "limit",
     *        description = "个数",
     *        required = false,
     *        type = "string",
     *        default = "20",
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "schema",
     *        description = "模式",
     *        required = false,
     *        type = "string",
     *        default = "mixture",
     *        enum = {"left", "mixture"}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功，返回主课件列表"
     *     ),
     * )
     *
     */
    public function actionSearch($keyword = '', $schema = 'left', $limit = 20)
    {
        $keyword = trim($keyword);

        if (!$keyword) {
            return [];
        }

        $model = new $this->modelClass;
        return $model->searchCourse($keyword);

        /*
        $modelClass = $this->modelClass;
        $model = new $modelClass;
        $model = $modelClass::find()->where([
            'status'        => $modelClass::COURSEWARE_STATUS_VALID,
            'courseware_id' => $model->prentCourseware()
        ])->andWhere([
            'or',
            ['like','title',$keyword],
            ['like','title',$body],
        ])->asArray()->all();

        return $model;
        */
    }

    /**
     * @SWG\Post(path="/course/collect",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="收藏主课程",
     *     description="返回提示信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_master_id",
     *        description = "主课程 ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "收藏状态：10收藏；20取消收藏",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum = {10,20}
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回成功信息，失败返回具体信息"
     *     ),
     * )
     *
     */
    public function actionCollect()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }
        if (!isset(Yii::$app->request->post()['status']) || empty(Yii::$app->request->post('status'))) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'status 不能为空';
            return [];
        }

        $model = Collect::find()->where([
            'user_id'          => Yii::$app->user->identity->id,
            'course_master_id' => Yii::$app->request->post('course_master_id')
        ])->one();

        // 创建
        if (!$model) {
            $model = new Collect;
            $model->user_id = Yii::$app->user->identity->id;
            if (!$model->load(Yii::$app->request->post(),'') || !$model->save()) {
                $this->serializer['errno']   = __LINE__;
                $this->serializer['message'] = $model->getErrors();
            }
            return [];
        }

        // 更新，包括全部子课程
        $count = Collect::updateAll([
            'status' => Yii::$app->request->post('status')
        ],[
            'user_id'          => Yii::$app->user->identity->id,
            'course_master_id' => Yii::$app->request->post('course_master_id')
        ]);

        if ($model->status != Yii::$app->request->post('status') && $count == 0) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'status 更新失败';
        }
        return [];
    }

    /**
     * @SWG\Post(path="/course/set-play-time",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="记录子课程视频播放时间",
     *     description="返回提示信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_master_id",
     *        description = "主课程 ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "course_id",
     *        description = "子课程 ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "play_back_time",
     *        description = "时间断点",
     *        required = true,
     *        type = "integer",
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "type",
     *        description = "文件类型",
     *        required = true,
     *        type = "string",
     *        default = "video/mp4",
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回成功信息，失败返回具体信息"
     *     ),
     * )
     *
     */
    public function actionSetPlayTime()
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        if (!isset($_POST['course_master_id']) || empty($_POST['course_master_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'course_master_id 不能为空';
            return [];
        }

        if (!isset($_POST['course_id']) || empty($_POST['course_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'course_id 不能为空';
            return [];
        }

        if (!isset($_POST['play_back_time']) || empty($_POST['play_back_time'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'play_back_time 不能为空';
            return [];
        }

        $query = Collect::find()->where([
            'user_id' => Yii::$app->user->identity->id
        ]);

        $master = $query->andWhere([
            'course_master_id' => $_POST['course_master_id'],
            'status'               => Collect::STATUS_COLLECTED,
            'course_id' => 0
        ])->one();
        if (!$master) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '主课件未被收藏';
            return [];
        }
        $model = $query->where([
            'user_id'              => Yii::$app->user->identity->id,
            'course_master_id' => $_POST['course_master_id'],
            'course_id'        => $_POST['course_id'],
        ])->one();

        // 创建
        if (!$model) {
            $model = new Collect;
            $model->user_id = Yii::$app->user->identity->id;
            $model->status  = $master->status;
            if (!$model->load($_POST,'') || !$model->save()) {
                $this->serializer['errno']   = __LINE__;
                $this->serializer['message'] = $model->getErrors();
                return [];
            }
        }

        // 更新
        $model->play_back_time = $_POST['play_back_time'];
        if (!$model->save()) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = $model->getErrors();
            return [];
        }
        return [];
    }

    /**
     * @SWG\Get(path="/course/get-play-time",
     *     tags={"GEDU-Course-课程接口"},
     *     summary="获取子课程视频播放时间记录",
     *     description="返回子课程视频播放时间记录",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "course_id",
     *        description = "子课程 ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "成功返回成功信息，失败返回具体信息"
     *     ),
     * )
     *
     */
    public function actionGetPlayTime($course_id = NULL)
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        if ($course_id == NULL) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'course_id 不能为空';
            return [];
        }

        $model = Collect::find()->where([
            'user_id'   => Yii::$app->user->identity->id,
            'course_id' => $course_id,
            'status'    => Collect::STATUS_COLLECTED
        ])->one();

        if (!$model) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '该记录不存在';
            return [];
        }
        return $model;

    }

}

?>