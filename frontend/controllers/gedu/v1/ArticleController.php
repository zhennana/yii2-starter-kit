<?php
namespace frontend\controllers\gedu\v1;

use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\ArticleCategory;


class ArticleController extends \common\rest\Controller
{
    /**
     * @var string
     */
    public $modelClass = 'common\models\Article';

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
     * @SWG\Get(path="/article/list",
     *     tags={"GEDU-Article-文章接口"},
     *     summary="button_id(文章父分类ID)",
     *     description="根据button ID返回文章列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "button_id(文章父分类ID)",
     *        required = true,
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回文章列表"
     *     ),
     * )
     *
    **/
    public function actionList($id)
    {
        $data = [];
        $modelClass = $this->modelClass;
        $child_cate = ArticleCategory::find()
            ->where(['parent_id' => $id])
            ->asArray()
            ->all();
        if (!isset($child_cate) || empty($child_cate)) {
            $this->serializer['errno']   = __LINE__;
            $this->serializer['message'] = '(Master)Category is null.';
            return [];
        }
        foreach ($child_cate as $key => $value) {
            $temp['category_id'] = $value['id'];
            $temp['title']       = $value['title'];
            $temp['url'] = Yii::$app->request->hostInfo;

            if ($value['id'] == 37) {
                $temp['url'] .= Url::to(['site/sights','category_id'=>$value['id']]);
            }elseif ($value['id'] == 38) {
                $temp['url'] .= Url::to(['site/teacher','category_id'=>$value['id']]);
            }else{
                $temp['url'] .= Url::to(['article/index','category_id'=>$value['id']]);
            }

            $data[] = $temp;
        }

        return $data;
    }

}

?>