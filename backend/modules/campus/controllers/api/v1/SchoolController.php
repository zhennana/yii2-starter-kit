<?php

namespace backend\modules\campus\controllers\api\v1;

/**
* This is the class for REST controller "SchoolController".
*/
use yii\web\Response;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\campus\models\School;
use backend\modules\campus\models\search\SchoolSearch;

class SchoolController extends \yii\rest\ActiveController
{
    public $modelClass = 'backend\modules\campus\models\School';
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [[
                        'allow'         => true,
                        'matchCallback' => function ($rule, $action) {
                            return \Yii::$app->user->can(
                                $this->module->id . '_' . $this->id . '_' . $action->id,
                                ['route' => true]
                            );
                        },
                    ]]
                ]
            ]
        );
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
        unset($actions['index'],$actions['create']);
        return $actions;
    }

    /**
     * @var array
     */
    public $serializer = [
        'class'              => 'common\rest\Serializer',   // 返回格式数据化字段
        'collectionEnvelope' => 'result',                   // 制定数据字段名称
        'errno'              => 0,                          // 错误处理数字
        'message'            => [ 'OK' ],                   // 文本提示
    ];

    /**
     * @SWG\Get(path="/campus/api/v1/school/index",
     *     tags={"200-School-学校接口"},
     *     summary="查询所有学校",
     *     description="返回学校信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "parent_id",
     *        description = "主校ID",
     *        required = false,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "school_title",
     *        description = "学校名称",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "school_short_title",
     *        description = "学校简称",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "school_slogan",
     *        description = "学校标语",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "school_logo_path",
     *        description = "Logo路径",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "school_backgroud_path",
     *        description = "背景图路径",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "province_id",
     *        description = "省",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "city_id",
     *        description = "城市",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "region_id",
     *        description = "区县",
     *        required = false,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "address",
     *        description = "区县",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "status",
     *        description = "状态：0正常；1标记删除",
     *        required = false,
     *        default = "0",
     *        type = "integer",
     *        enum = {0,1}
     *     ),
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "sort",
     *        description = "排序",
     *        required = false,
     *        default = "1",
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/
    public function actionIndex(){
        $searchModel = new SchoolSearch;
        $searchModel->load(\yii::$app->request->queryParams,'');
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['created_at' => SORT_DESC]
        ];
        return $dataProvider;

    }

     /**
     * @SWG\Post(path="/campus/api/v1/school/update?id=1",
     *     tags={"200-School-学校接口"},
     *     summary="查询所有学校",
     *     description="返回学校信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "parent_id",
     *        description = "主校ID",
     *        required = false,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_title",
     *        description = "学校名称",
     *        required = false,
     *        default = "燕郊在线",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_short_title",
     *        description = "学校简称",
     *        required = false,
     *        default = "燕郊在线",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_slogan",
     *        description = "学校标语",
     *        required = false,
     *        default = "燕郊在线",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_logo_path",
     *        description = "Logo路径",
     *        required = false,
     *        default = "Url",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_backgroud_path",
     *        description = "背景图路径",
     *        required = false,
     *        default = "url",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "province_id",
     *        description = "省",
     *        required = false,
     *        default = "1220",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "city_id",
     *        description = "城市",
     *        required = false,
     *        default = "1111",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "region_id",
     *        description = "区县",
     *        required = false,
     *        default = "111",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "address",
     *        description = "区县",
     *        required = false,
     *        default = "2222",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态：0正常；1标记删除",
     *        required = false,
     *        default = "1",
     *        type = "integer",
     *        enum = {0,1}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "sort",
     *        description = "排序",
     *        required = false,
     *        default = "1",
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/

    /**
     * @SWG\Get(path="/campus/api/v1/school/view",
     *     tags={"200-School-学校接口"},
     *     summary="查询学校",
     *     description="根据ID查询学校信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "query",
     *        name = "id",
     *        description = "学校ID",
     *        required = true,
     *        default = "1",
     *        type = "string"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回查询学校信息"
     *     ),
     * )
     *
    **/


    /**
     * @SWG\Post(path="/campus/api/v1/school/create",
     *     tags={"200-School-学校接口"},
     *     summary="创建学校",
     *     description="返回创建学校信息",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "parent_id",
     *        description = "主校ID",
     *        required = true,
     *        default = "0",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_title",
     *        description = "学校名称",
     *        required = true,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_short_title",
     *        description = "学校简称",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_slogan",
     *        description = "学校标语",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_logo_path",
     *        description = "Logo路径",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "school_backgroud_path",
     *        description = "背景图路径",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "province_id",
     *        description = "省",
     *        required = true,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "city_id",
     *        description = "城市",
     *        required = true,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "region_id",
     *        description = "区县",
     *        required = true,
     *        default = "",
     *        type = "integer"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "address",
     *        description = "区县",
     *        required = false,
     *        default = "",
     *        type = "string"
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "status",
     *        description = "状态：0正常；1标记删除",
     *        required = true,
     *        default = "0",
     *        type = "integer",
     *        enum = {0,1}
     *     ),
     *     @SWG\Parameter(
     *        in = "formData",
     *        name = "sort",
     *        description = "排序",
     *        required = true,
     *        default = "1",
     *        type = "integer"
     *     ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "返回创建学校信息"
     *     ),
     * )
     *
    **/
    public function actionCreate(){
        $model = new $this->modelClass;
        try{
            if ($model->load($_POST,'') && $model->save()) {
                    $model->school_id = $model->id;
                    $model->save();
            }
        }catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2]))?$e->errorInfo[2]:$e->getMessage();
            $model->addError('_exception', $msg);
            $this->serializer->errno = 400;
            //$this->serializer->message = $model->getErrors();
        }
        return $model;
    }
}
