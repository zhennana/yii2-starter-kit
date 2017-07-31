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
            $items = [];
            $model = $modelClass::find()->where([
                'category_id' => $value['id'],
                'status'      => $modelClass::STATUS_PUBLISHED
            ])->asArray()->all();

            $temp['child_cate_id'] = $value['id'];
            $temp['title']         = $value['title'];
            foreach ($model as $k => $v) {
                $item['article_id']      = $v['id'];
                $item['title']           = $v['title'];
                $item['body']            = $v['body'];
                $item['page_view']       = $v['page_view'];
                $item['unique_visitors'] = $v['unique_visitors'];
                $item['collect_number']  = $v['collect_number'];
                $item['comment_number']  = $v['comment_number'];
                $item['useless_number']  = $v['useless_number'];
                $item['published_at']    = date('Y-m-d H:i:s',$v['published_at']);
                $items[] = $item;
            }
            $temp['items'] = $items;
            unset($items);
            $data[] = $temp;
        }

        return $data;
    }

    /**
     * @SWG\Get(path="/article/contact",
     *     tags={"GEDU-Article-文章接口"},
     *     summary="联系我们",
     *     description="返回联系我们信息",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回联系我们信息"
     *     ),
     * )
    **/
    public function actionContact()
    {
        $data = [];

        $data = [
            'body' => '<p>学校地址：河北省三河市燕郊开发区燕灵路236号（三河二中西门路北）</p><p>邮编：065201</p><p>电话： 办公室： 0316-5997070 转6009</p><p>小学部办公室 转6003</p><p>中学部办公室 转6013</p><p>国际部办公室 转2599</p><p>招生办公室 转6688</p><p>董老师:13363653072, 杨老师:18034265209,马老师:18103165099</p><p>招生咨询时间：（周一至周日8:00-20:00）</p><p>网址：www.guangdaxuexiao.com</p>'
        ];
        return $data;
    }

}

?>