<?php

namespace backend\modules\campus\controllers\api\v1;

/**
* This is the class for REST controller "GradeController".
*/

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use backend\modules\campus\models\search\GradeSearch;

class GradeController extends \yii\rest\ActiveController
{
public $modelClass = 'backend\modules\campus\models\Grade';
    /**
    * @inheritdoc
    */
   /*
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [[
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {return \Yii::$app->user->can($this->module->id . '_' . $this->id . '_' . $action->id, ['route' => true]);},
                    ]]
                ]
            ]
        );
    }
*/
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

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_HTML;
        return $behaviors;
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'],$actions['create']);
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
     * @SWG\Get(path="/campus/api/v1/grade/index",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="展示班级数据",
     *     description="展示全部班级",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "query",
     *        name = "grade_id",
     *        description = "id查询",
     *        required = false,
     *        type = "string"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "group_category_id",
     *        description = "根据分类查询",
     *        required = false,
     *        type = "string"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "grade_name",
     *        description = "根据班级名查询",
     *        required = false,
     *        type = "string"
     *     ),
     *
     * @SWG\Parameter(
     *        in = "query",
     *        name = "owner_id",
     *        description = "根据班主任查询",
     *        required = false,
     *        type = "string"
     *     ),
     * @SWG\Parameter(
     *        in = "query",
     *        name = "creater_id",
     *        description = "根据创建者查询",
     *        required = false,
     *        type = "string"
     *     ),
     * @SWG\Parameter(
     *     in = "query",
     *     name = "status",
     *     description = "根据状态查询状态",
     *     required    = false,
     *     type =  "string"
     * ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     **/
    public function actionIndex(){
            $searchModel = new GradeSearch;
            $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
            $dataProvider->sort = [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ];
            return $dataProvider;
     }
    
    /**
     * @SWG\Get(path="/campus/api/v1/grade/view",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="展示单个班级数据",
     *     description="展示全部班级",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "id",
     *        required = true,
     *        type = "string"
     *     ),
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
    
    
    /**
     * @SWG\Post(path="/campus/api/v1/grade/update",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="修改班级数据",
     *     description="修改班级数据",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = true,
     *        type = "string"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校id",
     *        required = true,
     *        type = "string"
     *     ),   
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "group_category_id",
     *        description = "班级分类",
     *        required = true,
     *        type = "string"
     *     ),   
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "grade_name",
     *        description = "班级名称（string）",
     *        required = true,
     *        type = "string"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "owner_id",
     *        description = "班主任",
     *        required = true,
     *        type = "integer",
     *        enum ={10,0}
     *     ),  
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "sort",
     *        description = "排序",
     *        required = true,
     *        type = "integer"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态 10正常；0删除",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum ={10,0}
     *        
     *     ),  
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
  /*  
    public function actionUpdate($id = 10){
        
       $model =  new $this->modelClass;
       $model = $model::findOne($id);
        if(!$model){
            $this->serializer['errno']   = 400;
            $this->serializer['message'] = "数据异常";
            return [];
        }
        $model->load(\Yii::$app->request->post(),'');
        $model->save();
        return $model;
    }
*/

    
     /**
     * @SWG\Post(path="/campus/api/v1/grade/create",
     *     tags={"300-Grade-班级管理接口"},
     *     summary="修改班级数据",
     *     description="修改班级数据",
     *     produces={"application/json"},
     * @SWG\Parameter(
     *        in = "formData",
     *        name = "grade_id",
     *        description = "班级id",
     *        required = true,
     *        type = "string"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "school_id",
     *        description = "学校id",
     *        required = true,
     *        type = "string"
     *     ),   
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "group_category_id",
     *        description = "班级分类",
     *        required = true,
     *        type = "string"
     *     ),   
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "grade_name",
     *        description = "班级名称（string）",
     *        required = true,
     *        type = "string"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "owner_id",
     *        description = "班主任",
     *        required = true,
     *        type = "integer",
     *        enum ={10,0}
     *     ),  
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "sort",
     *        description = "排序",
     *        required = true,
     *        type = "integer"
     *     ),
     *@SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态 10正常；0删除",
     *        required = true,
     *        type = "integer",
     *        default = 10,
     *        enum ={10,0}
     *        
     *     ),  
     * @SWG\Response(
     *         response = 200,
     *         description = "200 返回成功"
     *     )
     * )
     */
}
