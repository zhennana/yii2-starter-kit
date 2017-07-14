<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use frontend\models\edu\resources\CoursewareToFile;
use frontend\models\edu\resources\Collect;


class CoursewareController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\edu\resources\Courseware';

    /**
     * @var arrayss
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
     * @SWG\Get(path="/courseware/list",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="课件列表",
     *     description="根据课件分类返回课件列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "category_id",
     *        description = "课件分类ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "根据课件分类返回课件列表"
     *     )
     * )
     *
    **/
    public function actionList($category_id)
    {
        $modelClass = new $this->modelClass;

        $model = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['category_id' => $category_id])
            ->andWhere(['courseware_id' => $modelClass->prentCourseware()])
            ->all();

        return $model;
    }

    /**
     * @SWG\Get(path="/courseware/view",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="课件内容",
     *     description="返回课件内容和相关课件列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_id",
     *        description = "课件ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回课件内容和相关课件列表"
     *     )
     * )
     *
    **/
    public function actionView($courseware_id)
    {
        $data = [];
        $modelClass = new $this->modelClass;

        $model = $modelClass::find()
            ->where(['courseware_id'=>$courseware_id])
            ->andWhere(['status'=>$modelClass::COURSEWARE_STATUS_VALID])
            ->one();
                    // var_dump($model);exit;
        if($model){
            $data = $model->toArray();
            $toCourseware = $model->getCoursewareToCourseware()->orderBy(['sort' => SORT_ASC])->all();
            foreach ($toCourseware as $key => $value) {
                if(isset($value->courseware)){
                    $data['items'][$key]         = $value->courseware->toArray();
                    $data['items'][$key]['sort'] = $value->sort;
                }
            }
        }

        return  $data;
      //return $data;
       // ->with(['coursewareToCourseware'=>function($model){
       //     return $model->with(['courseware']);
       // }])
       //->asArray()
            
       // var_dump();exit;
/*
        // 父课件
        $courseware = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['courseware_id' => $courseware_id])
            ->asArray()
            ->one();
        if (!$courseware) {
            return [];
        }
        $courseware['fileUrl'] = 'http://omsqlyn5t.bkt.clouddn.com/o_1bd0vghqqab37pr165sluc1sgq9.mp4';
        /*$sub_courseware = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['parent_id' => $courseware_id])
            ->asArray()
            ->all();
       for ($i=0; $i < 5; $i++) { 
            $data[$i] = $courseware;
       }
       $courseware['sub_courseware'] = $data;
*/
       return $model;

    }


    /**
     * @SWG\Get(path="/courseware/hot-words",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="热词",
     *     description="返回课件搜索词",
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
            'PHP','Android','牛津','英语','小学','计算机','IT','牛津英语','框架','后台开发','移动端','IOS','安卓','手机','工程师','出国','留学','哈佛','英语四级','php',
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
       return $data;
    }

    /**
     * @SWG\Get(path="/courseware/search",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="搜索主课件",
     *     description="返回主课件列表",
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
        return $model->searchCourseware($keyword);

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
     * @SWG\Post(path="/courseware/collect",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="收藏主课件",
     *     description="返回提示信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_master_id",
     *        description = "主课件 ID",
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
            'user_id'              => Yii::$app->user->identity->id,
            'courseware_master_id' => Yii::$app->request->post('courseware_master_id')
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

        // 更新，包括全部子课件
        $count = Collect::updateAll([
            'status' => Yii::$app->request->post('status')
        ],[
            'user_id'              => Yii::$app->user->identity->id,
            'courseware_master_id' => Yii::$app->request->post('courseware_master_id')
        ]);

        if ($model->status != Yii::$app->request->post('status') && $count == 0) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'status 更新失败';
        }
        return [];
    }

    /**
     * @SWG\Post(path="/courseware/set-play-time",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="记录子课件视频播放时间",
     *     description="返回提示信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_master_id",
     *        description = "主课件 ID",
     *        required = true,
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "courseware_id",
     *        description = "子课件 ID",
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

        if (!isset($_POST['courseware_master_id']) || empty($_POST['courseware_master_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'courseware_master_id 不能为空';
            return [];
        }

        if (!isset($_POST['courseware_id']) || empty($_POST['courseware_id'])) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'courseware_id 不能为空';
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
            'courseware_master_id' => $_POST['courseware_master_id'],
            'status'               => Collect::STATUS_COLLECTED,
            'courseware_id' => 0
        ])->one();
        if (!$master) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '主课件未被收藏';
            return [];
        }
        $model = $query->where([
            'user_id'              => Yii::$app->user->identity->id,
            'courseware_master_id' => $_POST['courseware_master_id'],
            'courseware_id'        => $_POST['courseware_id'],
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
     * @SWG\Get(path="/courseware/get-play-time",
     *     tags={"GEDU-Courseware-课件接口"},
     *     summary="获取子课件视频播放时间记录",
     *     description="返回子课件视频播放时间记录",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "courseware_id",
     *        description = "子课件 ID",
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
    public function actionGetPlayTime($courseware_id = NULL)
    {
        if(Yii::$app->user->isGuest){
            $this->serializer['errno']   = 422;
            $this->serializer['message'] = '请您先登录';
            return [];
        }

        if ($courseware_id == NULL) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = 'courseware_id 不能为空';
            return [];
        }

        $model = Collect::find()->where([
            'user_id'       => Yii::$app->user->identity->id,
            'courseware_id' => $courseware_id,
            'status'        => Collect::STATUS_COLLECTED
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