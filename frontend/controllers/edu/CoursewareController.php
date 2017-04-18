<?php
namespace frontend\controllers\edu;

use Yii;
use yii\web\Response;
use frontend\models\resources\CoursewareToFile;


class CoursewareController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\resources\Courseware';

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
     * @SWG\Get(path="/courseware/list",
     *     tags={"300-Courseware-课件接口"},
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
        $data = [];
        $modelClass = $this->modelClass;
        $model = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['category_id' => $category_id])
            ->andWhere(['parent_id' => 0])
            ->asArray()
            ->all();
        foreach ($model as $value) {
            // 课件图标
            $value['imgUrl'] = 'http://7xsm8j.com2.z0.glb.qiniucdn.com/ShanSong.png?imageView2/1/w/86/h/86';
            $data[] = $value;
        }

        return $data;
    }

    /**
     * @SWG\Get(path="/courseware/view",
     *     tags={"300-Courseware-课件接口"},
     *     summary="课件内容[待开发]",
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
        $modelClass = $this->modelClass;

        // 父课件
        $courseware = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['courseware_id' => $courseware_id])
            ->asArray()
            ->one();
        $sub_courseware = $modelClass::find()
            ->where(['status' => $modelClass::COURSEWARE_STATUS_VALID])
            ->andWhere(['parent_id' => $courseware_id])
            ->asArray()
            ->all();
        foreach ($sub_courseware as $value) {
            $value['fileUrl'] = 'http://omsqlyn5t.bkt.clouddn.com/o_1bd0vghqqab37pr165sluc1sgq9.mp4';
            $data[] = $value;
        }

        if (!$courseware) {
            return [];
        }
        $courseware['fileUrl'] = 'http://omsqlyn5t.bkt.clouddn.com/o_1bd0vghqqab37pr165sluc1sgq9.mp4';
        $courseware['sub_courseware'] = $data;
        return $courseware;
    }



}

?>