<?php
namespace backend\modules\campus\controllers\api\v1;
/**
* This is the class for REST controller "GradeCategroyController".
*/
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use \yii\web\Response;
use backend\modules\campus\models\search\GradeCategorySearch;

class GradeCategoryController extends \yii\rest\ActiveController
{
    public $modelClass = 'backend\modules\campus\models\GradeCategory';
    /**
    * @inheritdoc
    */
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
        
        /*
            return ArrayHelper::merge(
                parent::behaviors(),
                [
                    'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [[
                            'allow' => true,
                            'matchCallback' => function ($rule, $action) 
                            {
                                return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                        ]]
                    ]
                ]);

        */
    }

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

    public $serializer = [
            'class'=>'common\rest\Serializer',
            'collectionEnvelope'=>'result',
            'symbol'=>',',
            'errno'=>0,
            'message'=>['ok']
    ];

    /**
     * @SWG\Get(path="/campus/api/v1/grade-category/index",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="查询全部分类",
     *     description="查询全部分类",
     *     produces={"application/json"},
     *@SWG\Parameter(
     *        in = "query",
     *        name = "grade_category_id",
     *        description = "id",
     *        default  = 0,
     *        required = false,
     *        type = "integer"
     *     ), 
     * @SWG\Parameter(
     *        in = "query",
     *        name = "parent_id",
     *        description = "班级父分类",
     *        default  = 0,
     *        required = false,
     *        type = "integer"
     *     ), 
     * @SWG\Parameter(
     *        in = "query",
     *        name = "name",
     *         default  = 0,
     *        description = "分类名",
     *        required = false,
     *        type = "string"
     *     ), 
     * @SWG\Parameter(
     *        in = "query",
     *        name = "status",
     *        description = "状态 10正常；20关闭",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum ={10,20}
     *        
     *     ),  
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
    public function actionIndex(){
        $searchModel = new GradeCategorySearch;
        $searchModel->load(\yii::$app->request->queryParams,'');
        $dataProvider = $searchModel->search(\yii::$app->request->queryParams);
        $dataProvider->sort =[
            'defaultOrder'=>['created_at'=>SORT_DESC]
        ];
        return $dataProvider;
    }

    /**
     * @SWG\Post(path="/campus/api/v1/grade-category/create",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="创建班级分类",
     *     description="修改班级分类",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "parent_id",
     *        description = "班级父分类",
     *        required = false,
     *        type = "integer"
     *     ), 
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "name",
     *        description = "分类名",
     *        required = true,
     *        type = "string"
     *     ), 
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态 10正常；20关闭",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum ={10,20}
     *        
     *     ),  
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */

    /**
     * @SWG\Get(path="/campus/api/v1/grade-category/view",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="查看班级详情",
     *     description="查看班级详情",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "分类列表",
     *        required = true,
     *        type = "integer"
     *     ), 
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */

     /**
     * @SWG\Post(path="/campus/api/v1/grade-category/update?id=1",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="修改班级分类",
     *     description="修改班级分类",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "parent_id",
     *        description = "班级父分类",
     *        default  = 0,
     *        required = false,
     *        type = "integer"
     *     ), 
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "name",
     *         default  = 0,
     *        description = "分类名",
     *        required = true,
     *        type = "string"
     *     ), 
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态 10正常；20关闭",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum ={10,20}
     *        
     *     ),  
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */

   
}
