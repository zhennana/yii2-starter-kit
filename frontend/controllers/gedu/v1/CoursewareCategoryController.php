<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;

use frontend\models\gedu\resources\CoursewareCategory;

class CoursewareCategoryController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'frontend\models\gedu\resources\CoursewareCategory';

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
     * @SWG\Get(path="/courseware-category/index",
     *     tags={"GEDU-CoursewareCategory-课件分类接口【废弃】"},
     *     summary="课件分类",
     *     description="返回课件分类信息",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回课件分类信息"
     *     ),
     * )
     *
    **/
    /**
     * [actionIndex description]
     * @return [type] [description]
     */
    public function actionIndex()
    {
        $modelClass =  new $this->modelClass;
        return  $modelClass->categoryList();

    }



}

?>